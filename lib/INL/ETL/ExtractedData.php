<?php

namespace INL\ETL;

use RecursiveArrayIterator;
/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class ExtractedData extends RecursiveArrayIterator
{
    /**
     * @param array $array
     * @param int $flags
     */
    public function __construct($array = array(), $flags = 0)
    {
        $items = $this->mapItems($array);
        parent::__construct($items, $flags);
    }

    /**
     * @param $array
     * @return array
     */
    private function mapItems($array)
    {
        $items = [];
        $itr = new RecursiveArrayIterator($array);
        if ($itr->hasChildren()) {
            $itr->rewind();
            do {
                $items[$itr->key()] = new ExtractedItemData($itr->current());
                $itr->next();
            } while ($itr->valid());
        } else {
            $items[$itr->key()] = new ExtractedItemData($itr->current());
        }
        return $items;
    }
}