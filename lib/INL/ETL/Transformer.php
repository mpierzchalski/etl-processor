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
     * @param mixed $itemData
     * @return mixed
     */
    public function transform($itemData);
}