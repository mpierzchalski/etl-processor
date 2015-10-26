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

    /** @var object */
    private $prototype;

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
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator(array_map(function ($reflectionProperty) {
            /** @var \ReflectionProperty $reflectionProperty */
            return $reflectionProperty->getName();
        }, $this->refClass->getProperties(\ReflectionProperty::IS_PRIVATE)));
    }

    /**
     * @param string $field
     * @param Extractor $extractor
     */
    public function transform($field, Extractor $extractor)
    {
        if (is_null($this->prototype)) {
            $this->prototype = $this->refClass->newInstanceWithoutConstructor();
        }

        $property = $this->refClass->getProperty($field);
        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }

        $transformMethod = 'transform' . ucfirst($field);
        if (method_exists($this->extension, $transformMethod)) {
            $value = $this->extension->{$transformMethod}($extractor);
            $property->setValue($this->prototype, $value);
        }
    }

    /**
     * @return mixed
     */
    public function getPrototype()
    {
        return $this->prototype;
    }
}