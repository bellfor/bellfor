<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Core\Compression
 */

namespace jtl\Connector\Core\IO;

class Temp
{
    /**
     * @return null|string
     */
    public static function generateDirectory()
    {
        $dir = Path::combine(sys_get_temp_dir(), 'con-' . uniqid());
        if (mkdir($dir)) {
            return $dir;
        }

        return null;
    }

    /**
     * @return string
     */
    public static function getDirectory()
    {
        return sys_get_temp_dir();
    }
}