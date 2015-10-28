<?php

namespace INL\ETL;

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
    }

    public function proceed()
    {
        $extractedData = $this->extractor->extract();
        if (!$extractedData instanceof ExtractedData) {
            throw new \InvalidArgumentException(
                'Extractor should return an instance of INL\\ETL\\ExtractedData class'
            );
        }
        if ($extractedData->hasChildren()) {
            $this->proceedWithItems($extractedData);
        } else {
            $this->proceedWithSingleItem($extractedData->current());
        }
        $this->loader->commit();
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
    }
}
