<?php

namespace INL\ETL\Transform;

use INL\ETL\Extractor;
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
     * @param Extractor $extractor
     * @return object
     */
    public function transform(Extractor $extractor)
    {
        $prototype = $this->refClass->newInstanceWithoutConstructor();
        $propertiesNames = $this->getPrototypePropertiesNames();

        foreach ($propertiesNames as $propertyName) {
            $this->transformSinglePropertyValue($extractor, $propertyName, $prototype);
        }
        return $prototype;
    }

    /**
     * @return array
     */
    private function getPrototypePropertiesNames()
    {
        return array_map(function ($reflectionProperty) {
            /** @var \ReflectionProperty $reflectionProperty */
            return $reflectionProperty->getName();
        }, $this->refClass->getProperties());
    }

    /**
     * @param Extractor $extractor
     * @param string $propertyName
     * @param $prototype
     */
    private function transformSinglePropertyValue(Extractor $extractor, $propertyName, $prototype)
    {
        $transformMethod = 'transform' . ucfirst($propertyName);
        if (!method_exists($this->extension, $transformMethod)) {
            throw new \InvalidArgumentException(
                sprintf('Method "%s" not found in transformer extension object', $transformMethod)
            );
        }
        $value = $this->extension->{$transformMethod}($extractor);
        $property = $this->refClass->getProperty($propertyName);
        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }
        $property->setValue($prototype, $value);
    }
}