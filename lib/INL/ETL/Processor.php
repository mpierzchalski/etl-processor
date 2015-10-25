<?php

namespace INL\ETL;

use INL\ETL\Transform\TransformerContext;

class Processor
{
    /** @var Extractor */
    private $extractor;

    /** @var Transformer */
    private $transformer;

    /**
     * @param Extractor $extractor
     * @param Transformer $transformer
     */
    public function __construct(Extractor $extractor, Transformer $transformer)
    {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
    }

    /**
     * @param mixed $data
     */
    public function proceed($data)
    {
        $this->extractor->bindData($data);
        $context = new TransformerContext($data, $this->extractor);
        foreach ($this->transformer->getFields() as $field) {
            $this->transformer->transform($field, $context);
        }
    }
}
