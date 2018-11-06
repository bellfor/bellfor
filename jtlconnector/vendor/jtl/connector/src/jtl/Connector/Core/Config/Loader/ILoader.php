<?php

/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Core\Config
 */

namespace jtl\Connector\Core\Config\Loader;

/**
 * Loader Interface
 *
 * @author David Spickers <david.spickers@jtl-software.de>
 */
interface ILoader
{

    public function read($key, $default = null);

    public function reads($values = array());

    public function write($key, $value);

    public function writes($values = array());

    public function getName();
    
    public function isWriteable();
    
    public function clear();
}
