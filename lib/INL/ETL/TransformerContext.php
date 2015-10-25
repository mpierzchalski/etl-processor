<?php

namespace INL\ETL\Transform;
use INL\ETL\Extractor;

/**
 * @author    Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @package   INL\ETL\Transform
 */
class TransformerContext
{
    /** @var mixed */
    private $data;

    /** @var Extractor */
    private $extractor;

    /**
     * @param mixed $data
     * @param Extractor $extractor
     */
    public function __construct($data, Extractor $extractor)
    {
        $this->data = $data;
        $this->extractor = $extractor;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Extractor
     */
    public function getExtractor()
    {
        return $this->extractor;
    }
}