<?php

namespace spec\INL\ETL\Transform;

use INL\ETL\TransformerExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use example\Object;
use example\ObjectTransformer;

class SimpleObjectTransformerSpec extends ObjectBehavior
{
    function it_transforms_extracted_item_data(ObjectTransformer $extension)
    {
        $extension->transformId(Argument::type('array'))->willReturn(1);
        $extension->transformName(Argument::type('array'))->willReturn(null);
        $extension->transformInfo(Argument::type('array'))->willReturn(null);
        $extension->transformStatus(Argument::type('array'))->willReturn(null);
        $extension->transformCreatedAt(Argument::type('array'))->willReturn(null);
        $extension->transformDeletedAt(Argument::type('array'))
            ->willReturn(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2015-01-01 10:00:00'));

        $this->beConstructedWith('example\\Object', $extension);
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $object = $this->transform(['id' => 1, 'deletedAt' => '2015-01-01 10:00:00']);
        $object->shouldReturnAnInstanceOf('example\\Object');
        $object->getId()->shouldReturn(1);
        $object->getDeletedAt()->shouldReturnAnInstanceOf('\DateTimeImmutable');
        $object->getName()->shouldReturn(null);
    }

    function it_transforms_extracted_item_data_without_transformer_extension()
    {
        $this->beConstructedWith('example\\Object');
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $object = $this->transform(['id' => 1, 'name' => 'John']);
        $object->shouldReturnAnInstanceOf('example\\Object');
        $object->getId()->shouldReturn(1);
        $object->getName()->shouldReturn('John');
    }

    function it_throws_an_exception_if_the_transform_extension_object_do_not_have_transform_method(
        TransformerExtension $extension
    ) {
        $this->beConstructedWith('example\\Object', $extension);
        $this->shouldHaveType('INL\ETL\Transform\SimpleObjectTransformer');
        $this->shouldThrow('\InvalidArgumentException')->during('transform', ['id' => 1]);
    }
}
