<?php

namespace INL\ETL;

use INL\ETL\Events\DataLoadedEvent;
use INL\ETL\Events\DataTransformedEvent;
use INL\ETL\Events\ItemDataTransformedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use INL\ETL\Events\DataExtractedEvent;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class CallableEventSubscriber implements EventSubscriberInterface
{
    /** @var array */
    private $events = [];

    /**
     * @param callable $onDataExtractedCallback
     * @param callable $onItemDataTransformedCallback
     * @param callable $onDataTransformedCallback
     * @param callable $onDataLoadedCallback
     */
    public function __construct(
        $onDataExtractedCallback = null,
        $onItemDataTransformedCallback = null,
        $onDataTransformedCallback = null,
        $onDataLoadedCallback = null
    ) {
        $this->events['onDataExtracted'] = $onDataExtractedCallback;
        $this->events['onItemDataTransformed'] = $onItemDataTransformedCallback;
        $this->events['onDataTransformed'] = $onDataTransformedCallback;
        $this->events['onDataLoaded'] = $onDataLoadedCallback;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ProcessorEvents::DATA_EXTRACTED => array('onDataExtracted', 0),
            ProcessorEvents::ITEM_DATA_TRANSFORMED => array('onItemDataTransformed', 0),
            ProcessorEvents::DATA_TRANSFORMED => array('onDataTransformed', 0),
            ProcessorEvents::DATA_LOADED => array('onDataLoaded', 0),
        );
    }

    /**
     * @param DataExtractedEvent $event
     */
    public function onDataExtracted(DataExtractedEvent $event)
    {
        if (null !== $callback = $this->events['onDataExtracted']) {
            call_user_func_array($this->events['onDataExtracted'], [$event]);
        }
    }

    /**
     * @param ItemDataTransformedEvent $event
     */
    public function onItemDataTransformed(ItemDataTransformedEvent $event)
    {
        if (null !== $callback = $this->events['onItemDataTransformed']) {
            call_user_func_array($this->events['onItemDataTransformed'], [$event]);
        }
    }

    /**
     * @param DataTransformedEvent $event
     */
    public function onDataTransformed(DataTransformedEvent $event)
    {
        if (null !== $callback = $this->events['onDataTransformed']) {
            call_user_func_array($this->events['onDataTransformed'], [$event]);
        }
    }

    /**
     * @param DataLoadedEvent $event
     */
    public function onDataLoaded(DataLoadedEvent $event)
    {
        if (null !== $callback = $this->events['onDataLoaded']) {
            call_user_func_array($this->events['onDataLoaded'], [$event]);
        }
    }
}