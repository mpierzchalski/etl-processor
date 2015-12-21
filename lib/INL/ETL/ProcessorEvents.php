<?php

namespace INL\ETL;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
final class ProcessorEvents
{
    const DATA_EXTRACTED = 'data.extracted';
    const ITEM_DATA_TRANSFORMED = 'item_data.transformed';
    const DATA_TRANSFORMED = 'data.transformed';
    const DATA_LOADED = 'data.loaded';
}