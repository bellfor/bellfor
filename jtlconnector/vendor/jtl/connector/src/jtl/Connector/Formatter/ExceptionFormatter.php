<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Formatter
 */

namespace jtl\Connector\Formatter;

class ExceptionFormatter
{
    public static function format(\Exception $exc)
    {
        return sprintf("Exception '%s' (Code: %s) with message '%s' in %s:%s", get_class($exc), $exc->getCode(), $exc->getMessage(), $exc->getFile(), $exc->getLine());
    }
}
