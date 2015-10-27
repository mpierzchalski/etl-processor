<?php

namespace INL\ETL\Load;

use INL\ETL\Loader;
/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class InMemoryLoader implements Loader
{
    /** @var array */
    private $stack = [];

    /**
     * @param mixed $subject
     * @return void
     */
    public function load($subject)
    {
        $this->stack[] = $subject;
    }

    public function commit()
    {}
} 