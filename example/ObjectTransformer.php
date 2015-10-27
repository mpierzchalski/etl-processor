<?php

namespace example;

use INL\ETL\ExtractedItemData;
use INL\ETL\TransformerExtension;
/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class ObjectTransformer implements TransformerExtension
{
    public function transformId(ExtractedItemData $itemData)
    {
        return $itemData['id'];
    }

    public function transformName(ExtractedItemData $itemData)
    {
        return $itemData['title'];
    }

    public function transformInfo(ExtractedItemData $itemData)
    {
        return $itemData['description'];
    }

    public function transformCreatedAt(ExtractedItemData $itemData)
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $itemData['created_at']);
    }

    public function transformStatus(ExtractedItemData $itemData)
    {
        return $itemData['status'];
    }
} 