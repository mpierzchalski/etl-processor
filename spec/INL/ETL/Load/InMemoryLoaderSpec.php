<?php

namespace spec\INL\ETL\Load;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryLoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('INL\ETL\Load\InMemoryLoader');
    }

    function it_loads_transformed_data($subject)
    {
        $this->load($subject);
    }

    function it_commits_loaded_data()
    {
        $this->commit();
    }
}
