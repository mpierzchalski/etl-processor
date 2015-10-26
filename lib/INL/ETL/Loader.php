<?php

namespace INL\ETL;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
interface Loader
{
    /**
     * @param mixed $subject
     * @return void
     */
    public function load($subject);
} 