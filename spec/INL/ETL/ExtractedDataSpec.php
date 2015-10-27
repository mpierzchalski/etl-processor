<?php

namespace spec\INL\ETL;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtractedDataSpec extends ObjectBehavior
{
    function it_is_initializable_with_numeric_index_array()
    {
        $array = [['id' => 1], ['id' => 2], ['id' => 3], ['id' => 4]];
        $this->beConstructedWith($array);
        $this->shouldHaveType('INL\ETL\ExtractedData');
    }

    function it_is_initializable_with_assoc_array()
    {
        $array = ['id' => 1, 'name' => 'Tom Cruise'];
        $this->beConstructedWith($array);
        $this->shouldHaveType('INL\ETL\ExtractedData');
    }
}
