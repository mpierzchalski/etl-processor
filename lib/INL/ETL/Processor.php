<?php

namespace INL\ETL;

use Symfony\Component\EventDispatcher\EventDispatcher;

use INL\ETL\Events\DataExtractedEvent;
use INL\ETL\Events\DataLoadedEvent;
use INL\ETL\Events\DataTransformedEvent;
use INL\ETL\Events\ItemDataTransformedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @package inlworkaround
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */
class Processor
{
    /** @var Extractor */
    private $extractor;

    /** @var Transformer */
    private $transformer;

    /** @var Loader */
    private $loader;

    /** @var EventDispatcher */
    private $eventDispatcher;

    /**
     * @param Extractor $extractor
     * @param Transformer $transformer
     * @param Loader $loader
     */
    public function __construct(Extractor $extractor, Transformer $transformer, Loader $loader)
    {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
        $this->loader = $loader;
        $this->eventDispatcher = new EventDispatcher();
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->eventDispatcher->addSubscriber($subscriber);
    }

    public function proceed()
    {
        $extractedData = $this->extractor->extract();
        if (!$extractedData instanceof ExtractedData) {
            throw new ProcessorException(sprintf(
                'Extraction result must be an instance of INL\\ETL\\ExtractedData, but %s was returned.',
                is_object($extractedData) ? get_class($extractedData) : gettype($extractedData)
            ));
        }

        $this->eventDispatcher->dispatch(
            ProcessorEvents::DATA_EXTRACTED,
            new DataExtractedEvent($extractedData)
        );
        if ($extractedData->count()) {
            if ($extractedData->hasChildren()) {
                $this->proceedWithItems($extractedData);
            } else {
                $this->proceedWithSingleItem($extractedData->current());
            }
        }
        $this->eventDispatcher->dispatch(
            ProcessorEvents::DATA_TRANSFORMED,
            new DataTransformedEvent()
        );

        $this->loader->commit();
        $this->eventDispatcher->dispatch(
            ProcessorEvents::DATA_LOADED,
            new DataLoadedEvent()
        );
    }

    /**
     * @param ExtractedData $data
     */
    private function proceedWithItems(ExtractedData $data)
    {
        do {
            $itemData = $data->current();
            $this->proceedWithSingleItem($itemData);
            $data->next();
        } while ($data->valid());
    }

    /**
     * @param mixed $itemData
     */
    private function proceedWithSingleItem($itemData)
    {
        $transformedData = $this->transformer->transform($itemData);
        $this->loader->load($transformedData);
        $this->eventDispatcher->dispatch(
            ProcessorEvents::ITEM_DATA_TRANSFORMED,
            new ItemDataTransformedEvent($transformedData)
        );
    }
}
