<?php

namespace spec\INL\ETL\Extract;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayExtractorSpec extends ObjectBehavior
{
    function it_is_initializable_with_array()
    {
        $this->beConstructedWith([[1], [2], [3]]);
        $this->shouldHaveType('INL\ETL\Extract\ArrayExtractor');
    }

    function it_extracts_data_from_given_array()
    {
        $this->beConstructedWith([[1], [2], [3]]);
        $this->extract()->shouldReturnAnInstanceOf('INL\ETL\ExtractedData');
    }
}
