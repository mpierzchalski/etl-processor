<?php

namespace INL\ETL;

use INL\ETL\Transform\TransformerContext;
/**
 * @author    Michał Pierzchalski <michal.pierzchalski@gmail.com.pl>
 * @package   INL\ETL
 * @since     2015-10-23 
 */
interface Transformer
{
    /**
     * @return array
     */
    public function getFields();

    /**
     * @param string $field
     * @param TransformerContext $context
     */
    public function transform($field, TransformerContext $context);
}