<?php

namespace spec\INL\ETL\Transform;

use INL\ETL\ExtractedItemData;
use INL\ETL\TransformerExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use example\Object;
use example\ObjectTransformer;

class SimpleObjectTransformerSpec extends ObjectBehavior
{
    function it_transforms_extracted_item_data(ObjectTransformer $extension)
    {
        $this->beConstructedWith('example\\Object', $extension);
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $this->transform(['id' => 1]);
    }

    function it_throws_an_exception_if_the_transform_extension_object_do_not_have_transform_method(
        TransformerExtension $extension
    ) {
        $this->beConstructedWith('example\\Object', $extension);
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $this->shouldThrow('\InvalidArgumentException')->during('transform', ['id' => 1]);
    }
}
