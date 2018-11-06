<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Core\Config
 */

namespace jtl\Connector\Core\Config;

use \jtl\Connector\Core\Exception\ConfigException;
use \jtl\Connector\Core\Config\Loader\ILoader;
use \jtl\Connector\Core\System\Tool as SystemTool;

/**
 * Base Config Class
 *
 * @access public
 * @author David Spickers <david.spickers@jtl-software.de>
 */
class Base
{
    const PATTERN_COMBINED = '([A-Za-z0-9_]*)';
    const DELIMITER = '[\W+]';
    const SPACER = '||';

    /**
     * @var array
     */
    protected $loaders;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $loader_data;

    /**
     * @var array
     */
    protected $loaded;

    /**
     * @var type
     */
    protected $parsed_loader_data;

    /**
     * Creates the config instance.
     *
     * @param array $loaders A array with loaders that implements the ILoader
     * interface.
     */
    public function __construct(array $loaders)
    {
        if (!empty($loaders)) {
            foreach ($loaders as $loader) {
                $this->addLoader($loader);
            }
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->loaders);
        unset($this->parsed_loader_data);
        unset($this->loader_data);
    }

    /**
     * Reads multiple/single requests to the configuration.
     *
     * @param array $keys An array with stings as entries.
     * @return array An array with the values from $keys as index-keys.
     */
    public function reads($keys)
    {
        $ret = array();
        if ($keys === null || empty($keys)) { //Empty keys maybe need also be processed
            $ret = $this->read();
        } elseif (is_array($keys)) {
            foreach ($keys as $key => $value) {
                if (is_string($value)) {
                    $ret[$value] = $this->read($value);
                }
            }
        }
        return $ret;
    }

    /**
     * Retrieves the data array from the loader and stores it.
     *
     * @param \jtl\Connector\Core\Config\Loader\ILoader $loader
     */
    protected function retrieveAndMerge(ILoader $loader)
    {
        $loader_data = null;
        if (!array_key_exists($loader->getName(), $this->loader_data)) { //If we've no loader datas, we need to acquire this ones
            $loader->trigger('beforeRead'); //Trigger our loader
            $loader_data = $loader->read(null); //We need all datas without a special key
            $this->loader_data[$loader->getName()] = $loader_data;
            $this->loaded[$loader->getName()] = true;
        }
        if (!empty($loader_data) && is_array($loader_data)) { //Implement only if our loader has datas
            $this->parsed_loader_data = array_replace_recursive($this->parsed_loader_data, $loader_data);
        }
    }

    /**
     * Returns the values of a key, or all datas if the key is not provided.
     *
     * @param string $key The index key of the requested datas.
     * @return mixed The data value of the index key.
     * @throws ConfigException
     */
    public function read($key = null)
    {
        $ret = array();
        if (empty($this->parsed_loader_data)) { //If our storage is not present..
            $this->parsed_loader_data = array();
            if (empty($this->loaders)) {
                throw new ConfigException('No config loader is present', 100);
            }
            if (empty($this->loader_data)) { //If we have already a stored session we dont need to create the storage
                $this->loader_data = array();
                foreach ($this->loaders as $loader) {
                    $this->retrieveAndMerge($loader);
                }
            }
        }
        foreach ($this->loaded as $loader => $isloaded) {
            if (!$isloaded) {
                $this->retrieveAndMerge($this->loaders[$loader]);
            }
        }
        if (empty($key)) { //Return the complete loader datas
            return $this->parsed_loader_data;
        } elseif (array_key_exists($key, $this->parsed_loader_data)) { //Check if the key is available and returns it
            $ret = $this->parsed_loader_data[$key];
        } elseif ($this->isCombined($key)) { //If there is a custom string combined request (contacted strings)
            $ret = $this->readCombine($key, null, $this->parsed_loader_data);
        } elseif (empty($ret)) {
            throw new ConfigException(sprintf('Your request "%s" is not implemented yet!', $key), 100);
        }

        return $ret;
    }

    /**
     * Returns the value of a combined key string/index.
     * If the index is available in $this->data, there will be recursivly checked
     * if the depending keys are available.
     *
     * Is there no value, $default will be returned.
     *
     * @param string $key
     * @param mixed $default
     * @param array $loader_data
     * @return mixed
     */
    public function readCombine($key, $default = null, &$loader_data = array())
    {
        if (!empty($key) && !empty($loader_data)) {
            $keys = array();
            $key = preg_replace(self::DELIMITER, self::SPACER, $key);
            if (strpos($key, self::SPACER) !== false) {
                $keys = explode(self::SPACER, substr($key, strlen(self::SPACER)));
            }
            if (!empty($keys)) { //There are key matches
                $val = $default;
                $t_loader_data = $loader_data;
                for ($i = 0; $i < count($keys); $i++) {
                    if (array_key_exists($keys[$i], $t_loader_data)) {
                        $val = $t_loader_data[$keys[$i]];
                        $t_loader_data = $t_loader_data[$keys[$i]];
                    }
                }
                return $val;
            }
        }
        return $default;
    }

    /**
     * Returns if the provided key is a combined key.
     *
     * @param string $key A combined key as string.
     * @return bool
     */
    protected function isCombined($key)
    {
        return preg_match(self::DELIMITER, $key) && preg_match(self::PATTERN_COMBINED, $key);
    }

    /**
     * Writes multiple/single requests to the configuration.
     *
     * @param array $values An array with index-kex=>key-value as entries.
     * @return array An array with the values from $keys as index-keys.
     */
    public function writes($values)
    {
        $ret = array();
        if (is_array($values)) {
            foreach ($values as $obj) {
                $ret[$obj->key] = $this->write($obj);
            }
        }
        return $ret;
    }

    /**
     * Writes key/values.
     *
     * @param \stdClass $values The key value array that should be written.
     * @return array
     */
    public function write($values)
    {
        if (!is_object($values)) {
            throw new ConfigException('Object required', 100);
        }
        $vars = SystemTool::get_object_vars($values);
        if ($vars === null) {
            throw new ConfigException('Unable to read the object variables', 100);
        }
        if (!array_key_exists('key', $vars) || !array_key_exists('value', $vars)) {
            throw new ConfigException('Your object doesn\'t fit the config schema. You are required to use the parameters "key" and "value".', 100);
        }
        $key = $values->key;
        $value = $values->value;
        if (!empty($this->loaders)) {
            foreach ($this->loaders as $loader) {
                if ($loader->isWriteable()) {
                    $loader->write($key, $value);
                }
            }
        }
        return true;
    }

    /**
     * Checks if a loader is already added.
     *
     * @param string $name The loader name.
     */
    public function existsLoaderByName($name)
    {
        return (!empty($this->loaders)) && array_key_exists($name, $this->loaders);
    }

    /**
     * Checks if a loader is already added.
     *
     * @param \jtl\Connector\Core\Config\Base $loader
     * @throws ConfigException
     */
    protected function existsLoader(ILoader $loader)
    {
        if (!empty($this->loaders)) {
            foreach ($this->loaders as $key => $value) {
                if ($value->getName() == $loader->getName()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns a loader by name.
     *
     * @param string $name
     * @return boolean | \jtl\Connector\Core\Config\Loader\ILoader
     */
    public function getLoader($name)
    {
        if ($this->existsLoaderByName($name)) {
            return $this->loaders[$name];
        }
        return false;
    }

    /**
     * Adds a new loader to the class.
     *
     * @param \jtl\Connector\Core\Config\Base $loader
     */
    public function addLoader(ILoader $loader)
    {
        if ($this->existsLoader($loader)) {
            throw new ConfigException(sprintf('Duplicate Loader!!! The loader "%s" is already loaded at this point!', $loader->getName()), 100);
        }
        $this->loaders[$loader->getName()] = $loader;
        $this->loaded[$loader->getName()] = false;
    }

    /**
     * Deletes a existing loader.
     *
     * @param string $name The name of the loader that should be deleted.
     * @return boolean
     * @throws ConfigException If the loader is not present raise exception.
     */
    public function deleteLoader($name)
    {
        if (!isset($this->loaders[$name])) {
            throw new ConfigException(sprintf('The loader "%s" doesn\'t exist!', $name), 100);
        }
        unset($this->loaders[$name]);
        return true;
    }

    /**
     * Clears the actual loaders from the instance.
     *
     * @return boolean
     */
    public function clearLoader()
    {
        unset($this->loaders);
        $this->loaders = array();
        return true;
    }
}
