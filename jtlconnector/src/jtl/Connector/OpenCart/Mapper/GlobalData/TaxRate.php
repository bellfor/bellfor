<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Mapper\GlobalData;

use jtl\Connector\OpenCart\Mapper\BaseMapper;

class TaxRate extends BaseMapper
{
    protected $pull = [
        'id' => 'tax_rate_id',
        'rate' => 'rate'
    ];
}