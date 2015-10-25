<?php

namespace spec\INL\ETL;

use INL\ETL\Extractor;
use INL\ETL\Transformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessorSpec extends ObjectBehavior
{
    function let(Extractor $extractor, Transformer $transformer)
    {
        $this->beConstructedWith($extractor, $transformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('INL\ETL\Processor');
    }

    function it_proceeds_with_data($data)
    {
        $this->proceed($data);
    }
}
