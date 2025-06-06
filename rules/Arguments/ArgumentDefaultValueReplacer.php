<?php

declare (strict_types=1);
namespace Rector\Arguments;

use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Arguments\Contract\ReplaceArgumentDefaultValueInterface;
use Rector\Arguments\ValueObject\ReplaceArgumentDefaultValue;
use Rector\PhpParser\Node\NodeFactory;
use Rector\PhpParser\Node\Value\ValueResolver;
final class ArgumentDefaultValueReplacer
{
    /**
     * @readonly
     */
    private NodeFactory $nodeFactory;
    /**
     * @readonly
     */
    private ValueResolver $valueResolver;
    public function __construct(NodeFactory $nodeFactory, ValueResolver $valueResolver)
    {
        $this->nodeFactory = $nodeFactory;
        $this->valueResolver = $valueResolver;
    }
    /**
     * @template TCall as (MethodCall|StaticCall|ClassMethod|FuncCall|New_)
     *
     * @param \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall|\PhpParser\Node\Stmt\ClassMethod|\PhpParser\Node\Expr\FuncCall|\PhpParser\Node\Expr\New_ $node
     * @return TCall|null
     */
    public function processReplaces($node, ReplaceArgumentDefaultValueInterface $replaceArgumentDefaultValue)
    {
        if ($node instanceof ClassMethod) {
            if (!isset($node->params[$replaceArgumentDefaultValue->getPosition()])) {
                return null;
            }
            return $this->processParams($node, $replaceArgumentDefaultValue);
        }
        if (!isset($node->args[$replaceArgumentDefaultValue->getPosition()])) {
            return null;
        }
        return $this->processArgs($node, $replaceArgumentDefaultValue);
    }
    /**
     * @param mixed $value
     */
    private function isDefaultValueMatched(?Expr $expr, $value) : bool
    {
        // allow any values before, also allow param without default value
        if ($value === ReplaceArgumentDefaultValue::ANY_VALUE_BEFORE) {
            return \true;
        }
        if (!$expr instanceof Expr) {
            return \false;
        }
        if ($this->valueResolver->isValue($expr, $value)) {
            return \true;
        }
        // ValueResolver::isValue returns false when default value is `null`
        return $value === null && $this->valueResolver->isNull($expr);
    }
    private function processParams(ClassMethod $classMethod, ReplaceArgumentDefaultValueInterface $replaceArgumentDefaultValue) : ?ClassMethod
    {
        $position = $replaceArgumentDefaultValue->getPosition();
        if (!$this->isDefaultValueMatched($classMethod->params[$position]->default, $replaceArgumentDefaultValue->getValueBefore())) {
            return null;
        }
        $classMethod->params[$position]->default = $this->normalizeValue($replaceArgumentDefaultValue->getValueAfter());
        return $classMethod;
    }
    /**
     * @template TCall as (MethodCall|StaticCall|FuncCall|New_)
     *
     * @param \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall|\PhpParser\Node\Expr\FuncCall|\PhpParser\Node\Expr\New_ $expr
     * @return TCall|null
     */
    private function processArgs($expr, ReplaceArgumentDefaultValueInterface $replaceArgumentDefaultValue) : ?Expr
    {
        if ($expr->isFirstClassCallable()) {
            return null;
        }
        $position = $replaceArgumentDefaultValue->getPosition();
        $particularArg = $expr->getArgs()[$position] ?? null;
        if (!$particularArg instanceof Arg) {
            return null;
        }
        $argValue = $this->valueResolver->getValue($particularArg->value);
        if (\is_scalar($replaceArgumentDefaultValue->getValueBefore()) && $argValue === $replaceArgumentDefaultValue->getValueBefore()) {
            $expr->args[$position] = $this->normalizeValueToArgument($replaceArgumentDefaultValue->getValueAfter());
            return $expr;
        }
        if (\is_array($replaceArgumentDefaultValue->getValueBefore())) {
            $newArgs = $this->processArrayReplacement($expr->getArgs(), $replaceArgumentDefaultValue);
            if (\is_array($newArgs)) {
                $expr->args = $newArgs;
                return $expr;
            }
        }
        return null;
    }
    /**
     * @param mixed $value
     */
    private function normalizeValueToArgument($value) : Arg
    {
        return new Arg($this->normalizeValue($value));
    }
    /**
     * @return \PhpParser\Node\Expr\ClassConstFetch|\PhpParser\Node\Expr
     * @param mixed $value
     */
    private function normalizeValue($value)
    {
        // class constants → turn string to composite
        if (\is_string($value) && \strpos($value, '::') !== \false) {
            [$class, $constant] = \explode('::', $value);
            return $this->nodeFactory->createClassConstFetch($class, $constant);
        }
        return BuilderHelpers::normalizeValue($value);
    }
    /**
     * @param array<int, Arg> $args
     * @return array<int, Arg>|null
     */
    private function processArrayReplacement(array $args, ReplaceArgumentDefaultValueInterface $replaceArgumentDefaultValue) : ?array
    {
        $argumentValues = $this->resolveArgumentValuesToBeforeRecipe($args, $replaceArgumentDefaultValue);
        if ($argumentValues !== $replaceArgumentDefaultValue->getValueBefore()) {
            return null;
        }
        if (\is_string($replaceArgumentDefaultValue->getValueAfter())) {
            $args[$replaceArgumentDefaultValue->getPosition()] = $this->normalizeValueToArgument($replaceArgumentDefaultValue->getValueAfter());
            // clear following arguments
            $argumentCountToClear = \count($replaceArgumentDefaultValue->getValueBefore());
            for ($i = $replaceArgumentDefaultValue->getPosition() + 1; $i <= $replaceArgumentDefaultValue->getPosition() + $argumentCountToClear; ++$i) {
                unset($args[$i]);
            }
        }
        return $args;
    }
    /**
     * @param Arg[] $argumentNodes
     * @return mixed[]
     */
    private function resolveArgumentValuesToBeforeRecipe(array $argumentNodes, ReplaceArgumentDefaultValueInterface $replaceArgumentDefaultValue) : array
    {
        $argumentValues = [];
        $valueBefore = $replaceArgumentDefaultValue->getValueBefore();
        if (!\is_array($valueBefore)) {
            return [];
        }
        $beforeArgumentCount = \count($valueBefore);
        for ($i = 0; $i < $beforeArgumentCount; ++$i) {
            if (!isset($argumentNodes[$replaceArgumentDefaultValue->getPosition() + $i])) {
                continue;
            }
            $nextArg = $argumentNodes[$replaceArgumentDefaultValue->getPosition() + $i];
            $argumentValues[] = $this->valueResolver->getValue($nextArg->value);
        }
        return $argumentValues;
    }
}
