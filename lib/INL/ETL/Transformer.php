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
     * @param ExtractedItemData $itemData
     * @return mixed
     */
    public function transform(ExtractedItemData $itemData);
}