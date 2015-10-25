<?php

namespace INL\ETL\Transform;

use INL\ETL\Transformer;
use INL\ETL\TransformerExtension;
/**
 * @author    Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @package   INL\ETL\Transform
 * @since     2015-10-23 
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
     * @return array|string[]
     */
    public function getFields()
    {
        return array_map(function ($reflectionProperty) {
            /** @var \ReflectionProperty $reflectionProperty */
            return $reflectionProperty->getName();
        }, $this->refClass->getProperties(\ReflectionProperty::IS_PRIVATE));
    }

    /**
     * @param string $field
     * @param TransformerContext $context
     */
    public function transform($field, TransformerContext $context)
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
            $value = $this->extension->{$transformMethod}($context);
            $property->setValue($this->prototype, $value);
        }
    }
}