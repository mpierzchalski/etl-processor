<?php

namespace INL\ETL\Events;

use INL\ETL\ExtractedData;
use Symfony\Component\EventDispatcher\Event;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class DataExtractedEvent extends Event
{
    /** @var ExtractedData */
    private $data;

    /**
     * @param ExtractedData $data
     */
    public function __construct(ExtractedData $data)
    {
        $this->data = $data;
    }

    /**
     * @return ExtractedData
     */
    public function getData()
    {
        return $this->data;
    }
}