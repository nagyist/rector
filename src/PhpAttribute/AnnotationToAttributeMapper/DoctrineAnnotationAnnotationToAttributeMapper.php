<?php

declare (strict_types=1);
namespace Rector\PhpAttribute\AnnotationToAttributeMapper;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\Exception\ShouldNotHappenException;
use Rector\Php\PhpVersionProvider;
use Rector\PhpAttribute\AnnotationToAttributeMapper;
use Rector\PhpAttribute\AttributeArrayNameInliner;
use Rector\PhpAttribute\Contract\AnnotationToAttributeMapperInterface;
use Rector\ValueObject\PhpVersionFeature;
/**
 * @implements AnnotationToAttributeMapperInterface<DoctrineAnnotationTagValueNode>
 */
final class DoctrineAnnotationAnnotationToAttributeMapper implements AnnotationToAttributeMapperInterface
{
    /**
     * @readonly
     */
    private PhpVersionProvider $phpVersionProvider;
    /**
     * @readonly
     */
    private AttributeArrayNameInliner $attributeArrayNameInliner;
    private AnnotationToAttributeMapper $annotationToAttributeMapper;
    public function __construct(PhpVersionProvider $phpVersionProvider, AttributeArrayNameInliner $attributeArrayNameInliner)
    {
        $this->phpVersionProvider = $phpVersionProvider;
        $this->attributeArrayNameInliner = $attributeArrayNameInliner;
    }
    /**
     * Avoid circular reference
     */
    public function autowire(AnnotationToAttributeMapper $annotationToAttributeMapper) : void
    {
        $this->annotationToAttributeMapper = $annotationToAttributeMapper;
    }
    /**
     * @param mixed $value
     */
    public function isCandidate($value) : bool
    {
        if (!$value instanceof DoctrineAnnotationTagValueNode) {
            return \false;
        }
        return $this->phpVersionProvider->isAtLeastPhpVersion(PhpVersionFeature::NEW_INITIALIZERS);
    }
    /**
     * @param DoctrineAnnotationTagValueNode $value
     */
    public function map($value) : New_
    {
        $annotationShortName = $this->resolveAnnotationName($value);
        $values = $value->getValues();
        if ($values !== []) {
            $argValues = $this->annotationToAttributeMapper->map($value->getValues());
            if ($argValues instanceof Array_) {
                // create named args
                $args = $this->attributeArrayNameInliner->inlineArrayToArgs($argValues);
            } else {
                throw new ShouldNotHappenException();
            }
        } else {
            $args = [];
        }
        return new New_(new Name($annotationShortName), $args);
    }
    private function resolveAnnotationName(DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode) : string
    {
        $annotationShortName = $doctrineAnnotationTagValueNode->identifierTypeNode->name;
        return \ltrim($annotationShortName, '@');
    }
}
