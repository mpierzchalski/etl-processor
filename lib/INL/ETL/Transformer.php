<?php

namespace INL\ETL;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
interface Transformer
{
    /**
     * @return \ArrayIterator
     */
    public function getIterator();

    /**
     * @param string $field
     * @param Extractor $extractor
     */
    public function transform($field, Extractor $extractor);

    /**
     * @return mixed
     */
    public function getPrototype();
}