<?php

namespace INL\ETL;

/**
 * @author    Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @package   INL\ETL
 * @since     2015-10-23 
 */
interface Extractor extends \Iterator, \Countable
{
    /**
     * @param mixed $data
     */
    public function bindData($data);
}