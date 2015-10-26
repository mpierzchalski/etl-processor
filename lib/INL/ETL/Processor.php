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
        $iterator = $this->transformer->getIterator();
        do {
            $this->transformer->transform($iterator->current(), $this->extractor);
            $iterator->next();
        } while ($iterator->valid());

        $prototype = $this->transformer->getPrototype();
        $this->loader->load($prototype);
    }
}
