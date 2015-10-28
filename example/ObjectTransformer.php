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
    public function transformId($itemData)
    {
        return $itemData['id'];
    }

    public function transformName( $itemData)
    {
        return $itemData['title'];
    }

    public function transformInfo( $itemData)
    {
        return $itemData['description'];
    }

    public function transformCreatedAt( $itemData)
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $itemData['created_at']);
    }

    public function transformStatus( $itemData)
    {
        return $itemData['status'];
    }

    public function transformDeletedAt( $itemData)
    {
        if ($itemData['deleted_at']) {
            return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $itemData['deleted_at']);
        }
        return null;
    }
} 