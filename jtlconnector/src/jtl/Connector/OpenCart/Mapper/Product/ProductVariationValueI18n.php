<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Mapper\Product;

use jtl\Connector\OpenCart\Mapper\I18nBaseMapper;

class ProductVariationValueI18n extends I18nBaseMapper
{
    protected $pull = [
        'productVariationValueId' => 'product_option_value_id',
        'name' => null,
        'languageISO' => null,
    ];

    protected function name(array $data)
    {
        return isset($data['name']) ? html_entity_decode($data['name']) : '';
    }
}