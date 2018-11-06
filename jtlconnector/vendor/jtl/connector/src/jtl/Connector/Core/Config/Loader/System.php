<?php

/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Core\Config
 */

namespace jtl\Connector\Core\Config\Loader;

use \jtl\Connector\Core\Config\Loader\Base as BaseLoader;
use \jtl\Connector\Core\System\Tool as SystemTool;
use \jtl\Connector\Core\Http\Ssl;

/**
 * System Loader Class
 *
 * @access public
 * @author David Spickers <david.spickers@jtl-software.de>
 *
 * @todo: 1. Windows load einbauen
 */
class System extends BaseLoader
{
    //OS

    const OS_LINUX = 'lin';
    const OS_WINDOWS = 'win';

    //Sections
    const CFG_SECTION_HTTP = 'http';
    const CFG_SECTION_PHP = 'php';
    const CFG_SECTION_COMPRESSION = 'compression';
    const CFG_SECTION_LOAD = 'load';
    const CFG_SECTION_AVGLOAD = 'avgload';

    //Php functions
    const CMD_PHP_POST_MAX_SIZE = 'max_post_size';
    const CMD_PHP_MAX_EXECUTION_TIME = 'max_execution_time';
    const CMD_PHP_MEMORY_USAGE = 'memory_usage';
    const CMD_PHP_MEMORY_REAL_USAGE = 'memory_real_usage';
    const CMD_PHP_UPLOAD_MAX_FILESIZE = 'upload_max_filesize';
    const CMD_PHP_MAX_FILE_UPLOADS = 'max_file_uploads';
    const CMD_PHP_MEMORY_LIMIT = 'memory_limit';
    const CMD_PHP_CONNECTOR_UPLOAD_MAX_SIZE = 'connector_upload_max_size';

    /**
     * @var string
     */
    protected $name = 'System';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->os = strtolower(substr(PHP_OS, 0, 3));
    }

    /**
     * Sets the operating system to the given value.
     *
     * @param string $os
     */
    public function setOs($os)
    {
        $this->os = $os;
    }

    /**
     * Returns the first three characters of the operating system string.
     *
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Returns the value for a given name.
     *
     * @param string $key Name of the required information.
     * @param mixed $default Default value if the command/name is not implemented yet.
     * @return mixed
     */
    public function read($key, $default = null)
    {
        switch ($key) {
            case self::CFG_SECTION_PHP:
                {//Return the php section
                    $this->setSectionPhp();
                } break;
            case self::CFG_SECTION_HTTP:
                { //Return the server section
                    $this->setSectionHttp();
                } break;
            case self::CFG_SECTION_COMPRESSION:
                { //Return the compression
                    $this->setSectionCompression();
                } break;
            case self::CFG_SECTION_LOAD:
                { //Return the loading
                    $this->setSectionLoad();
                } break;
            case self::CFG_SECTION_AVGLOAD:
                { //Return the loading
                    $this->setSectionLoad(true);
                } break;
            default:
                {  //Return the datas to all sections
                    $this->setSectionPhp();
                    $this->setSectionHttp();
                    $this->setSectionCompression();
                    $this->setSectionLoad();
                }
                break;
        }
        if (!empty($this->data)) { //If the data array is set
            return $this->data;
        }
        //@codeCoverageIgnoreStart
        return $default;
        //@codeCoverageIgnoreEnd
    }

    /**
     * Returns the section php.
     *
     * @throws \RuntimeException
     */
    public function setSectionPhp()
    {
        $this->data[self::CFG_SECTION_PHP] = array(
          self::CMD_PHP_MAX_EXECUTION_TIME => ini_get('max_execution_time'),
          self::CMD_PHP_POST_MAX_SIZE => $this->getBytes(ini_get('post_max_size')),
          self::CMD_PHP_MEMORY_LIMIT => $this->getBytes(ini_get('memory_limit')),
          self::CMD_PHP_UPLOAD_MAX_FILESIZE => $this->getBytes(ini_get('upload_max_filesize')),
          self::CMD_PHP_MAX_FILE_UPLOADS => $this->getBytes(ini_get('max_file_uploads')),
          self::CMD_PHP_MEMORY_USAGE => $this->getBytes(memory_get_usage(true)),
          self::CMD_PHP_MEMORY_REAL_USAGE => $this->getBytes(memory_get_usage()),
        );

        $php = &$this->data[self::CFG_SECTION_PHP];
        $php[self::CMD_PHP_CONNECTOR_UPLOAD_MAX_SIZE] = 0;
        if ($php[self::CMD_PHP_MEMORY_LIMIT] < $php[self::CMD_PHP_POST_MAX_SIZE]) {
            $php[self::CMD_PHP_CONNECTOR_UPLOAD_MAX_SIZE] = $php[self::CMD_PHP_MEMORY_LIMIT];
        } elseif ($php[self::CMD_PHP_POST_MAX_SIZE] < $php[self::CMD_PHP_UPLOAD_MAX_FILESIZE]) {
            $php[self::CMD_PHP_CONNECTOR_UPLOAD_MAX_SIZE] = $php[self::CMD_PHP_MEMORY_LIMIT];
        } else {
            $php[self::CMD_PHP_CONNECTOR_UPLOAD_MAX_SIZE] = $php[self::CMD_PHP_UPLOAD_MAX_FILESIZE];
        }
    }

    /**
     * Returns the http section.
     *
     * @return array
     */
    public function setSectionHttp()
    {
        $this->data[self::CFG_SECTION_HTTP] = array(
          'ssl' => Ssl::isEnabled()
        );
    }

    /**
     * Returns the section compression.
     *
     * @return array
     */
    public function setSectionCompression()
    {
        $this->data[self::CFG_SECTION_COMPRESSION] = null;
        if (function_exists("gzcompress")) {
            $this->data[self::CFG_SECTION_COMPRESSION][] = 'gzip';
        }
        if (function_exists("gzdeflate")) {
            $this->data[self::CFG_SECTION_COMPRESSION][] = 'deflate';
        }
    }

    /**
     * Returns the server load.
     */
    public function setSectionLoad()
    {
        $this->data[self::CFG_SECTION_LOAD] = array();
        try {
            switch ($this->os) {
                case self::OS_WINDOWS:
                    { //Windows based systems
                        $load = SystemTool::sys_win_getloadavg();
                        $this->data[self::CFG_SECTION_LOAD] = $load[0]; //Average
                        $this->data[self::CFG_SECTION_AVGLOAD] = $load; //Actual
                    } break;
                case self::OS_LINUX:
                    { //Linux based systemsv
                        $load = SystemTool::sys_getloadavg();
                        $this->data[self::CFG_SECTION_LOAD] = $load[0]; //Average
                        $this->data[self::CFG_SECTION_AVGLOAD] = $load; //Actual
                    } break;
            }
        } catch (\Exception $e) {
            $this->data[self::CFG_SECTION_AVGLOAD] = 0;
            $this->data[self::CFG_SECTION_LOAD] = 0;
        }
    }

    /**
     * Calculates memory strings into bytes.
     * Provided by http://php.net/manual/en/function.ini-get.php.
     *
     * @param string $v
     * @return integer
     */
    public function getBytes($v)
    {
        $v = trim($v);
        $last = strtolower($v[strlen($v) - 1]);
        switch ($last) {
            case 'g':
                $v *= 1024;
            case 'm':
                $v *= 1024;
            case 'k':
                $v *= 1024;
        }
        return (int) $v;
    }
}
