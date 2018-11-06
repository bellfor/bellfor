<?php

/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Core\Config
 */

namespace jtl\Connector\Core\Config\Loader;

use \jtl\Connector\Core\Config\Loader\Base as BaseLoader;
use \jtl\Connector\Core\Exception\ConfigException;
use \jtl\Connector\Core\Filesystem\Tool;
use \jtl\Connector\Core\Serializer\Json as SerializerJson;

/**
 * Json Loader Class
 *
 * @access public
 * @author David Spickers <david.spickers@jtl-software.de>
 */
class Json extends BaseLoader
{

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $name = 'Json';

    /**
     * @var Bool
     */
    protected $canWrite = true;

    /**
     * Creates the instance.
     *
     * @param string $file The full filename of a JSON config file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Will be triggered before the READ method is called, to initialize the
     * content when it is required.
     *
     * @throws ConfigException
     */
    public function beforeRead()
    {
        if (empty($this->data)) {
            if (!Tool::is_file($this->file)) {
                throw new ConfigException(sprintf('Unable to load configuration file "%s"', $this->file), 100);
            }
            $content = Tool::file_get_contents($this->file);
            if ($content === false) {
                throw new ConfigException(sprintf('Unable to read file content from file "%s"', $this->file), 100);
            }
            $this->data = SerializerJson::decode($content, true);
        }
    }

    /**
     * Saves the values to the configuration file in json format.
     *
     * @return boolean
     */
    protected function save()
    {
        if (!Tool::is_writable($this->file)) {
            throw new ConfigException(sprintf('File %s is not writable', $this->file), 100);
        }
        $ret = Tool::file_put_contents($this->file, SerializerJson::encode($this->data, true));
        if ($ret === false) {
            throw new ConfigException(sprintf('Unable to save %s', $this->file), 100);
        }
        return true;
    }
}
