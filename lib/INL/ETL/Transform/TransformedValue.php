<?php

namespace INL\ETL\Transform;

/**
 * @author    Michał Pierzchalski <michal.pierzchalski@invicta.pl>
 * @package   INL\ETL\Transform
 * @since     2015-10-23 
 */
class TransformedValue
{
    /** @var string */
    private $field = '';

    /** @var mixed */
    private $value;

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}