<?php

declare (strict_types=1);
namespace Rector\Php81\NodeAnalyzer;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar;
use Rector\Core\NodeAnalyzer\ExprAnalyzer;
final class ComplexNewAnalyzer
{
    /**
     * @readonly
     * @var \Rector\Core\NodeAnalyzer\ExprAnalyzer
     */
    private $exprAnalyzer;
    public function __construct(\Rector\Core\NodeAnalyzer\ExprAnalyzer $exprAnalyzer)
    {
        $this->exprAnalyzer = $exprAnalyzer;
    }
    public function isDynamic(\PhpParser\Node\Expr\New_ $new) : bool
    {
        if (!$new->class instanceof \PhpParser\Node\Name\FullyQualified) {
            return \true;
        }
        $args = $new->getArgs();
        foreach ($args as $arg) {
            $value = $arg->value;
            if ($this->isAllowedNew($value)) {
                continue;
            }
            if ($value instanceof \PhpParser\Node\Expr\Array_ && $this->isAllowedArray($value)) {
                continue;
            }
            if ($value instanceof \PhpParser\Node\Scalar) {
                continue;
            }
            if ($this->isAllowedConstFetchOrClassConstFeth($value)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function isAllowedConstFetchOrClassConstFeth(\PhpParser\Node\Expr $expr) : bool
    {
        if (!\in_array(\get_class($expr), [\PhpParser\Node\Expr\ConstFetch::class, \PhpParser\Node\Expr\ClassConstFetch::class], \true)) {
            return \false;
        }
        if ($expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return $expr->class instanceof \PhpParser\Node\Name && $expr->name instanceof \PhpParser\Node\Identifier;
        }
        return \true;
    }
    private function isAllowedNew(\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\New_) {
            return !$this->isDynamic($expr);
        }
        return \false;
    }
    private function isAllowedArray(\PhpParser\Node\Expr\Array_ $array) : bool
    {
        if (!$this->exprAnalyzer->isDynamicArray($array)) {
            return \true;
        }
        $arrayItems = $array->items;
        foreach ($arrayItems as $arrayItem) {
            if (!$arrayItem instanceof \PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            if (!$arrayItem->value instanceof \PhpParser\Node\Expr\New_) {
                return \false;
            }
            if ($this->isDynamic($arrayItem->value)) {
                return \false;
            }
        }
        return \true;
    }
}
