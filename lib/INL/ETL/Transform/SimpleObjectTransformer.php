<?php

namespace INL\ETL\Transform;

use INL\ETL\ExtractedItemData;
use INL\ETL\Transformer;
use INL\ETL\TransformerExtension;
/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class SimpleObjectTransformer implements Transformer
{
    /** @var \ReflectionClass */
    private $refClass;

    /** @var TransformerExtension */
    private $extension;

    /**
     * @param string|object $class
     * @param TransformerExtension $extension
     */
    public function __construct($class, TransformerExtension $extension)
    {
        $this->refClass = new \ReflectionClass($class);
        $this->extension = $extension;
    }

    /**
     * @param ExtractedItemData $itemData
     * @return object
     */
    public function transform(ExtractedItemData $itemData)
    {
        $prototype = $this->refClass->newInstanceWithoutConstructor();
        foreach ($this->getProperties() as $property) {
            $transformedValue = $this->transformSinglePropertyValue($itemData, $property->getName(), $prototype);
            $this->bindValue($property, $transformedValue, $prototype);
        }
        return $prototype;
    }

    /**
     * @return array|\ReflectionProperty[]
     */
    private function getProperties()
    {
        $properties = [];
        $class = $this->refClass;
        do {
            $properties = array_merge($class->getProperties(), $properties);
        } while($class = $class->getParentClass());
        return $properties;
    }

    /**
     * @param ExtractedItemData $itemData
     * @param string $propertyName
     * @return mixed
     */
    private function transformSinglePropertyValue(ExtractedItemData $itemData, $propertyName)
    {
        $transformMethod = 'transform' . ucfirst($propertyName);
        if (!method_exists($this->extension, $transformMethod)) {
            throw new \InvalidArgumentException(
                sprintf('Method "%s" not found in transformer extension object', $transformMethod)
            );
        }
        return $this->extension->{$transformMethod}($itemData);
    }

    /**
     * @param \ReflectionProperty $property
     * @param mixed $value
     * @param object $object
     */
    private function bindValue(\ReflectionProperty $property, $value, $object)
    {
        $setterName = 'set' . ucfirst($property->getName());
        if (method_exists($object, $setterName)) {
            $object->{$setterName}($value);
        } else {
            if (!$property->isPublic()) {
                $property->setAccessible(true);
            }
            $property->setValue($object, $value);
        }
    }
}