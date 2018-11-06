<?php

/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Core\Config
 */

namespace jtl\Connector\Core\Config\Loader;

use \jtl\Connector\Core\Config\Loader\ILoader;
use \jtl\Connector\Core\Exception\ConfigException;

abstract class Base implements ILoader
{

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var bool
     */
    protected $canWrite = false;

    /**
     * @var array
     */
    protected $triggered = array();

    /**
     * Returns the Loader name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Checks if a method exists in a loader and calls it.
     *
     * @param string $name The name of the method that will be triggered.
     * @return mixed The return value of the method triggered.
     */
    public function trigger($name)
    {
        if (!isset($this->triggered[$name]) && method_exists($this, $name)) {
            $this->triggered[$name] = 1;
            return $this->{$name}();
        }
        return false;
    }

    /**
     * Clears the data array.
     */
    public function clear()
    {
        unset($this->data);
        $this->data = array();
    }

    /**
     * Returns if the Loader can write to the configuration.
     *
     * @return bool
     */
    public function isWriteable()
    {
        return $this->canWrite;
    }

    /**
     * Returns a defined key.
     *
     * @param string $key Should be a key inside of the data array.
     * @param string $default Default configuration value
     * @return mixed
     */
    public function read($key, $default = null)
    {
        if (is_array($this->data) && array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } elseif (empty($key) || $key == null) {
            return $this->data;
        }
        return $default;
    }

    /**
     * Reads N keys from the data array.
     *
     * @param array $values The values array
     * @return array
     */
    public function reads($values = array())
    {
        $vals = array();
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $vals[] = $this->read($value);
            }
        }
        return $vals;
    }

    /**
     * Writes the configuration.
     *
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function write($key, $value = null)
    {
        if (empty($key)) {
            throw new ConfigException(sprintf('"%s" is not a valid key string', $key), 100);
        }
        if (empty($this->data) || !is_array($this->data)) {
            $this->data = array();
        }
        if (!array_key_exists($key, $this->data) || $this->data[$key] != $value) {
            $this->data[$key] = $value;
            if (method_exists($this, 'save')) {
                return $this->save();
            }
            return true;
        }
        return false;
    }

    /**
     * Writes N values in the configuration.
     *
     * @param array $values The key/string combination array
     */
    public function writes($values = array())
    {
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $this->write($key, $value);
            }
            return true;
        }
        return false;
    }

    /**
     * Dynamically returning all class constants supported.
     *
     * @param string $prefix
     * @param bool $only_keys
     * @param int $char_len
     * @return mixed
     */
    public function retrieveConstants($prefix, $only_keys = true, $char_len = 3)
    {
        $consts = array();
        $rc = new \ReflectionClass($this);
        $bconsts = $rc->getConstants();
        unset($rc);
        if (!empty($bconsts)) {
            foreach ($bconsts as $key => $value) {
                if (substr($key, 0, $char_len) === $prefix) {
                    $consts[$key] = $value;
                }
            }
        }
        if ($only_keys) {
            return array_keys($consts);
        }
        return $consts;
    }
}
