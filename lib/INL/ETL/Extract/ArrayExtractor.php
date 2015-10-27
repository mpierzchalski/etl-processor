<?php

namespace INL\ETL\Extract;

use INL\ETL\Extractor;
use INL\ETL\ExtractedData;
/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class ArrayExtractor implements Extractor
{
    /** @var array */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return ExtractedData
     */
    public function extract()
    {
        return new ExtractedData($this->data);
    }

}