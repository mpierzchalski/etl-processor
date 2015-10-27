<?php

namespace INL\ETL;

use INL\ETL\Extract\ArrayExtractor;
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
        $this->extractor->rewind();
        if ($this->extractor->hasChildren()) {
            $this->proceedWithItems($this->extractor);
        } else {
            $this->proceedWithSingleItem($this->extractor->current());
        }
    }

    /**
     * @param \RecursiveIterator $itemsExtractor
     */
    private function proceedWithItems(\RecursiveIterator $itemsExtractor)
    {
        do {
            $extractedItem = new ArrayExtractor($itemsExtractor->current());
            $this->proceedWithSingleItem($extractedItem);
            $itemsExtractor->next();
        } while ($itemsExtractor->valid());
    }

    /**
     * @param mixed $item
     */
    private function proceedWithSingleItem($item)
    {
        $transformedData = $this->transformer->transform($item);
        $this->loader->load($transformedData);
    }
}
