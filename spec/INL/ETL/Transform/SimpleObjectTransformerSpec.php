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
    function it_transforms_extracted_item_data(
        ExtractedItemData $extractedItemData,
        ObjectTransformer $extension
    ) {
        $this->beConstructedWith('example\\Object', $extension);
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $this->transform($extractedItemData);
    }

    function it_throws_an_exception_if_the_transform_extension_object_do_not_have_transform_method(
        ExtractedItemData $extractedItemData,
        TransformerExtension $extension
    ) {
        $this->beConstructedWith('example\\Object', $extension);
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $this->shouldThrow('\InvalidArgumentException')->during('transform', [$extractedItemData]);
    }
}
