<?php

namespace INL\ETL;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
interface Extractor
{
    /**
     * @return ExtractedData
     */
    public function extract();
}