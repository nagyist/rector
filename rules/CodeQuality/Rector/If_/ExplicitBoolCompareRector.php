<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Greater;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\Float_;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\CodeQuality\Rector\If_\ExplicitBoolCompareRector\ExplicitBoolCompareRectorTest
 */
final class ExplicitBoolCompareRector extends AbstractRector
{
    /**
     * @readonly
     */
    private StringTypeAnalyzer $stringTypeAnalyzer;
    /**
     * @readonly
     */
    private ArrayTypeAnalyzer $arrayTypeAnalyzer;
    /**
     * @readonly
     */
    private ValueResolver $valueResolver;
    public function __construct(StringTypeAnalyzer $stringTypeAnalyzer, ArrayTypeAnalyzer $arrayTypeAnalyzer, ValueResolver $valueResolver)
    {
        $this->stringTypeAnalyzer = $stringTypeAnalyzer;
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->valueResolver = $valueResolver;
    }
    public function getRuleDefinition() : RuleDefinition
    {
        return new RuleDefinition('Make if conditions more explicit', [new CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function run($items)
    {
        if (!count($items)) {
            return 'no items';
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    public function run($items)
    {
        if (count($items) === 0) {
            return 'no items';
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [If_::class, ElseIf_::class, Ternary::class];
    }
    /**
     * @param If_|ElseIf_|Ternary $node
     * @return null|Stmt[]|Node
     */
    public function refactor(Node $node)
    {
        // skip short ternary
        if ($node instanceof Ternary && !$node->if instanceof Expr) {
            return null;
        }
        if ($node->cond instanceof BooleanNot) {
            $conditionNode = $node->cond->expr;
            $isNegated = \true;
        } else {
            $conditionNode = $node->cond;
            $isNegated = \false;
        }
        if ($conditionNode instanceof Bool_) {
            return null;
        }
        $conditionStaticType = $this->nodeTypeResolver->getNativeType($conditionNode);
        if ($conditionStaticType instanceof MixedType || $conditionStaticType->isBoolean()->yes()) {
            return null;
        }
        $binaryOp = $this->resolveNewConditionNode($conditionNode, $isNegated);
        if (!$binaryOp instanceof Expr) {
            return null;
        }
        if ($node instanceof If_ && $node->cond instanceof Assign && $binaryOp instanceof BinaryOp && $binaryOp->left instanceof NotIdentical && $binaryOp->right instanceof NotIdentical) {
            $expression = new Expression($node->cond);
            $binaryOp->left->left = $node->cond->var;
            $binaryOp->right->left = $node->cond->var;
            $node->cond = $binaryOp;
            return [$expression, $node];
        }
        $node->cond = $binaryOp;
        return $node;
    }
    /**
     * @return \PhpParser\Node\Expr\BinaryOp|\PhpParser\Node\Expr\Instanceof_|\PhpParser\Node\Expr\BooleanNot|null
     */
    private function resolveNewConditionNode(Expr $expr, bool $isNegated)
    {
        if ($expr instanceof FuncCall && $this->isName($expr, 'count')) {
            return $this->resolveCount($isNegated, $expr);
        }
        if ($this->arrayTypeAnalyzer->isArrayType($expr)) {
            return $this->resolveArray($isNegated, $expr);
        }
        if ($this->stringTypeAnalyzer->isStringOrUnionStringOnlyType($expr)) {
            return $this->resolveString($isNegated, $expr);
        }
        $exprType = $this->getType($expr);
        if ($exprType->isInteger()->yes()) {
            return $this->resolveInteger($isNegated, $expr);
        }
        if ($exprType->isFloat()->yes()) {
            return $this->resolveFloat($isNegated, $expr);
        }
        $objectType = $this->nodeTypeResolver->matchNullableTypeOfSpecificType($expr, ObjectType::class);
        if ($objectType instanceof ObjectType) {
            return $this->resolveNullable($isNegated, $expr, $objectType);
        }
        return null;
    }
    /**
     * @return \PhpParser\Node\Expr\BinaryOp\Identical|\PhpParser\Node\Expr\BinaryOp\Greater|null
     */
    private function resolveCount(bool $isNegated, FuncCall $funcCall)
    {
        if ($funcCall->isFirstClassCallable()) {
            return null;
        }
        $countedType = $this->getType($funcCall->getArgs()[0]->value);
        if ($countedType->isArray()->yes()) {
            return null;
        }
        $int = new Int_(0);
        // compare === 0, assumption
        if ($isNegated) {
            return new Identical($funcCall, $int);
        }
        return new Greater($funcCall, $int);
    }
    /**
     * @return Identical|NotIdentical|null
     */
    private function resolveArray(bool $isNegated, Expr $expr) : ?BinaryOp
    {
        if (!$expr instanceof Variable) {
            return null;
        }
        $array = new Array_([]);
        // compare === []
        if ($isNegated) {
            return new Identical($expr, $array);
        }
        return new NotIdentical($expr, $array);
    }
    /**
     * @return \PhpParser\Node\Expr\BinaryOp\Identical|\PhpParser\Node\Expr\BinaryOp\NotIdentical|\PhpParser\Node\Expr\BinaryOp\BooleanAnd|\PhpParser\Node\Expr\BinaryOp\BooleanOr
     */
    private function resolveString(bool $isNegated, Expr $expr)
    {
        $emptyString = new String_('');
        $identical = $this->resolveIdentical($expr, $isNegated, $emptyString);
        $value = $this->valueResolver->getValue($expr);
        // unknown value. may be from parameter
        if ($value === null) {
            return $this->resolveZeroIdenticalString($identical, $isNegated, $expr);
        }
        $length = \strlen((string) $value);
        if ($length === 1) {
            $zeroString = new String_('0');
            return $this->resolveIdentical($expr, $isNegated, $zeroString);
        }
        return $identical;
    }
    /**
     * @return \PhpParser\Node\Expr\BinaryOp\Identical|\PhpParser\Node\Expr\BinaryOp\NotIdentical
     */
    private function resolveIdentical(Expr $expr, bool $isNegated, String_ $string)
    {
        /**
         * // compare === ''
         *
         * @var Identical|NotIdentical
         */
        $identical = $isNegated ? new Identical($expr, $string) : new NotIdentical($expr, $string);
        return $identical;
    }
    /**
     * @param \PhpParser\Node\Expr\BinaryOp\Identical|\PhpParser\Node\Expr\BinaryOp\NotIdentical $identical
     * @return \PhpParser\Node\Expr\BinaryOp\BooleanAnd|\PhpParser\Node\Expr\BinaryOp\BooleanOr
     */
    private function resolveZeroIdenticalString($identical, bool $isNegated, Expr $expr)
    {
        $string = new String_('0');
        $zeroIdentical = $isNegated ? new Identical($expr, $string) : new NotIdentical($expr, $string);
        return $isNegated ? new BooleanOr($identical, $zeroIdentical) : new BooleanAnd($identical, $zeroIdentical);
    }
    /**
     * @return \PhpParser\Node\Expr\BinaryOp\Identical|\PhpParser\Node\Expr\BinaryOp\NotIdentical
     */
    private function resolveInteger(bool $isNegated, Expr $expr)
    {
        $int = new Int_(0);
        if ($isNegated) {
            return new Identical($expr, $int);
        }
        return new NotIdentical($expr, $int);
    }
    /**
     * @return \PhpParser\Node\Expr\BinaryOp\Identical|\PhpParser\Node\Expr\BinaryOp\NotIdentical
     */
    private function resolveFloat(bool $isNegated, Expr $expr)
    {
        $float = new Float_(0.0);
        if ($isNegated) {
            return new Identical($expr, $float);
        }
        return new NotIdentical($expr, $float);
    }
    /**
     * @return \PhpParser\Node\Expr\BooleanNot|\PhpParser\Node\Expr\Instanceof_
     */
    private function resolveNullable(bool $isNegated, Expr $expr, ObjectType $objectType)
    {
        $fullyQualified = new FullyQualified($objectType->getClassName());
        $instanceof = new Instanceof_($expr, $fullyQualified);
        return $isNegated ? new BooleanNot($instanceof) : $instanceof;
    }
}
