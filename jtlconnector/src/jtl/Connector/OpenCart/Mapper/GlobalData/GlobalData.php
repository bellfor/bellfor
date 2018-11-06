<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Mapper\GlobalData;

use jtl\Connector\OpenCart\Mapper\BaseMapper;

class GlobalData extends BaseMapper
{
    protected $pull = [
        'languages' => 'GlobalData\Language',
        'currencies' => 'GlobalData\Currency',
        'taxRates' => 'GlobalData\TaxRate',
        'customerGroups' => 'GlobalData\CustomerGroup',
        'measurementUnits' => 'GlobalData\MeasurementUnit',
        'shippingMethods' => 'GlobalData\ShippingMethod'
    ];

    public static function getModels()
    {
        return ['Language', 'Currency', 'TaxRate', 'CustomerGroup', 'MeasurementUnit', 'ShippingMethod'];
    }
}