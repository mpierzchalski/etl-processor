<?php

namespace spec\INL\ETL\Extract;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayExtractSpec extends ObjectBehavior
{
    function let()
    {
        $data = [
            'id' => 1,
            'partner_id' => '10002',
            'name' => 'Super Item',
            'address' => 'Wall Street 12',
            'localization' => 'New York',
            'GPS' => [
                'L' => '15.4577',
                'W' => '20.7845'
            ],
            'created_at' => '2011-10-12 12:53:36'
        ];
        $this->beConstructedWith($data);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('INL\ETL\Extract\ArrayExtract');
    }

    function it_extracts_data()
    {
    }
}
