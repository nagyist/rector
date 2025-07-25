<?php

declare (strict_types=1);
namespace Rector\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Error;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeVisitor;
use Rector\NodeManipulator\FuncCallManipulator;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\PhpDocParser\NodeTraverser\SimpleCallableNodeTraverser;
use Rector\PhpParser\Comparing\NodeComparator;
use Rector\PhpParser\Node\BetterNodeFinder;
final class ParamAnalyzer
{
    /**
     * @readonly
     */
    private NodeComparator $nodeComparator;
    /**
     * @readonly
     */
    private NodeNameResolver $nodeNameResolver;
    /**
     * @readonly
     */
    private FuncCallManipulator $funcCallManipulator;
    /**
     * @readonly
     */
    private SimpleCallableNodeTraverser $simpleCallableNodeTraverser;
    /**
     * @readonly
     */
    private BetterNodeFinder $betterNodeFinder;
    /**
     * @var string[]
     */
    private const VARIADIC_FUNCTION_NAMES = ['func_get_arg', 'func_get_args', 'func_num_args'];
    public function __construct(NodeComparator $nodeComparator, NodeNameResolver $nodeNameResolver, FuncCallManipulator $funcCallManipulator, SimpleCallableNodeTraverser $simpleCallableNodeTraverser, BetterNodeFinder $betterNodeFinder)
    {
        $this->nodeComparator = $nodeComparator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->funcCallManipulator = $funcCallManipulator;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isParamUsedInClassMethod(ClassMethod $classMethod, Param $param) : bool
    {
        if ($param->isPromoted()) {
            return \true;
        }
        $isParamUsed = \false;
        if ($param->var instanceof Error) {
            return \false;
        }
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod->stmts, function (Node $node) use(&$isParamUsed, $param) : ?int {
            if ($this->isVariadicFuncCall($node)) {
                $isParamUsed = \true;
                return NodeVisitor::STOP_TRAVERSAL;
            }
            if ($this->isUsedAsArg($node, $param)) {
                $isParamUsed = \true;
                return NodeVisitor::STOP_TRAVERSAL;
            }
            // skip nested anonymous class
            if ($node instanceof Class_ || $node instanceof Function_) {
                return NodeVisitor::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if ($node instanceof Variable && $this->nodeComparator->areNodesEqual($node, $param->var)) {
                $isParamUsed = \true;
                return NodeVisitor::STOP_TRAVERSAL;
            }
            if ($node instanceof Closure && $this->isVariableInClosureUses($node, $param->var)) {
                $isParamUsed = \true;
                return NodeVisitor::STOP_TRAVERSAL;
            }
            if ($this->isParamUsed($node, $param)) {
                $isParamUsed = \true;
                return NodeVisitor::STOP_TRAVERSAL;
            }
            return null;
        });
        return $isParamUsed;
    }
    /**
     * @param Param[] $params
     */
    public function hasPropertyPromotion(array $params) : bool
    {
        foreach ($params as $param) {
            if ($param->isPromoted()) {
                return \true;
            }
        }
        return \false;
    }
    public function isNullable(Param $param) : bool
    {
        if ($param->variadic) {
            return \false;
        }
        if (!$param->type instanceof Node) {
            return \false;
        }
        return $param->type instanceof NullableType;
    }
    public function isParamReassign(ClassMethod $classMethod, Param $param) : bool
    {
        $paramName = (string) $this->nodeNameResolver->getName($param->var);
        return (bool) $this->betterNodeFinder->findFirstInFunctionLikeScoped($classMethod, function (Node $node) use($paramName) : bool {
            if (!$node instanceof Assign) {
                return \false;
            }
            if (!$node->var instanceof Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node->var, $paramName);
        });
    }
    private function isVariableInClosureUses(Closure $closure, Variable $variable) : bool
    {
        foreach ($closure->uses as $use) {
            if ($this->nodeComparator->areNodesEqual($use->var, $variable)) {
                return \true;
            }
        }
        return \false;
    }
    private function isUsedAsArg(Node $node, Param $param) : bool
    {
        if ($node instanceof New_ || $node instanceof CallLike) {
            if ($node->isFirstClassCallable()) {
                return \false;
            }
            foreach ($node->getArgs() as $arg) {
                if ($this->nodeComparator->areNodesEqual($param->var, $arg->value)) {
                    return \true;
                }
            }
        }
        return \false;
    }
    private function isParamUsed(Node $node, Param $param) : bool
    {
        if (!$node instanceof FuncCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node, 'compact')) {
            return \false;
        }
        $arguments = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls([$node]);
        return $this->nodeNameResolver->isNames($param, $arguments);
    }
    private function isVariadicFuncCall(Node $node) : bool
    {
        if (!$node instanceof FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isNames($node, self::VARIADIC_FUNCTION_NAMES);
    }
}
