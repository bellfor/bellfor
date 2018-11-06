<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Mapper\Specific;

use jtl\Connector\OpenCart\Mapper\I18nBaseMapper;

class SpecificI18n extends I18nBaseMapper
{
    protected $pull = [
        'specificId' => 'filter_group_id',
        'name' => null,
        'languageISO' => null,
    ];

    protected $push = [
        'filter_group_id' => 'specificId',
        'name' => 'name'
    ];

    protected function name(array $data)
    {
        return isset($data['name']) ? html_entity_decode($data['name']) : '';
    }
}