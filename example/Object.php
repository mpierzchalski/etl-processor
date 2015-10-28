<?php

namespace example;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class Object extends InheritedObject
{
    private $deletedAt;

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
} 