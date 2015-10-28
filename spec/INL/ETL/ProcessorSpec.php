<?php

namespace spec\INL\ETL;

use INL\ETL\ExtractedData;
use INL\ETL\Extractor;
use INL\ETL\Loader;
use INL\ETL\Transformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessorSpec extends ObjectBehavior
{
    function let(
        Extractor $extractor,
        Transformer $transformer,
        Loader $loader,
        ExtractedData $extractedData
    ) {
        $extractedData->current()->willReturn([]);
        $extractor->extract()->willReturn($extractedData);
        $this->beConstructedWith($extractor, $transformer, $loader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('INL\ETL\Processor');
    }

    function it_proceeds_with_collection_of_extracted_data(ExtractedData $extractedData)
    {
        $extractedData->hasChildren()->willReturn(false);
        $this->proceed();
    }

    function it_proceeds_with_single_extracted_data(ExtractedData $extractedData)
    {
        $extractedData->hasChildren()->willReturn(true);
        $extractedData->next()->shouldBeCalled();
        $extractedData->valid()->shouldBeCalled();
        $this->proceed();
    }

    function it_throws_an_exception_if_extractor_does_not_return_an_instance_of_extracted_data(
        Extractor $extractor
    ) {
        $extractor->extract()->willReturn(null);
        $this->shouldThrow('\InvalidArgumentException')->during('proceed', []);
    }
}
