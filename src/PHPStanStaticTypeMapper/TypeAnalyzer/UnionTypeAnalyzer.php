<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeAnalyzer;

use PHPStan\Type\ArrayType;
use PHPStan\Type\IterableType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;
use Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis;
use Traversable;
final class UnionTypeAnalyzer
{
    public function analyseForArrayAndIterable(UnionType $unionType) : ?UnionTypeAnalysis
    {
        $hasIterable = \false;
        $hasArray = \false;
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof IterableType) {
                $hasIterable = \true;
                continue;
            }
            if ($unionedType instanceof ArrayType) {
                $hasArray = \true;
                continue;
            }
            if ($unionedType instanceof ObjectType && $unionedType->getClassName() === Traversable::class) {
                $hasIterable = \true;
                continue;
            }
            return null;
        }
        return new UnionTypeAnalysis($hasIterable, $hasArray);
    }
    public function isNullable(UnionType $unionType, bool $checkTwoTypes = \false) : bool
    {
        $types = $unionType->getTypes();
        if ($checkTwoTypes && \count($types) > 2) {
            return \false;
        }
        foreach ($types as $type) {
            if ($type instanceof NullType) {
                return \true;
            }
        }
        return \false;
    }
}
