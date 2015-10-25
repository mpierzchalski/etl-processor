<?php

namespace INL\ETL\Extract;

use INL\ETL\Extractor;
/**
 * @author    Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @package   INL\ETL\Extract
 * @since     2015-10-23 
 */
class ArrayExtractor implements Extractor
{
    /** @var array */
    private $data = [];

    /** @var \RecursiveArrayIterator */
    private $iterator;

    /**
     * @param array $data
     */
    public function bindData($data)
    {
        if (!is_null($this->iterator)) {
            throw new \InvalidArgumentException('Data cannot be set again.');
        }
        $this->data = $data;
        $this->iterator = new \RecursiveArrayIterator($data);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->iterator->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function extract()
    {
        //yyyy
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->iterator->count();
    }

}