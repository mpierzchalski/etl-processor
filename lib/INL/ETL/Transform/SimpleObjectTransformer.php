<?php

namespace INL\ETL\Transform;

use INL\ETL\ExtractedItemData;
use INL\ETL\Transformer;
use INL\ETL\TransformerExtension;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class SimpleObjectTransformer implements Transformer
{
    /** @var \ReflectionClass */
    private $refClass;

    /** @var TransformerExtension|null */
    private $extension;

    /**
     * @param string|object $class
     * @param TransformerExtension $extension
     */
    public function __construct($class, TransformerExtension $extension = null)
    {
        $this->refClass = new \ReflectionClass($class);
        $this->extension = $extension;
    }

    /**
     * @param mixed $itemData
     * @return object
     */
    public function transform($itemData)
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
     * @param mixed $itemData
     * @param string $propertyName
     * @return mixed
     */
    private function transformSinglePropertyValue($itemData, $propertyName)
    {
        if ($this->extension) {
            $transformMethod = 'transform' . ucfirst($propertyName);
            if (!method_exists($this->extension, $transformMethod)) {
                throw new \InvalidArgumentException(
                    sprintf('Method "%s" not found in transformer extension object', $transformMethod)
                );
            }
            return $this->extension->{$transformMethod}($itemData);

        } else {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $fixedPropertyName = is_array($itemData) ? sprintf('[%s]', $propertyName) : $propertyName;
            return $propertyAccessor->getValue($itemData, $fixedPropertyName);
        }
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