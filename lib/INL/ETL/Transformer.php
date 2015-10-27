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
     * @param Extractor $extractor
     * @return mixed
     */
    public function transform(Extractor $extractor);
}