<?php

/**
 *
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Application
 */

namespace jtl\Connector\Controller;

use \jtl\Connector\Core\Controller\Controller as CoreController;
use \jtl\Connector\Result\Action;
use \jtl\Connector\Core\Rpc\Error;

/**
 * Base Config Controller
 *
 * @access public
 * @author David Spickers <david.spickers@jtl-software.de>
 */
class Config extends CoreController
{

    /**
     * Returns the controller configuration and returns it.
     *
     * @param mixed $params An array of parameters to read
     */
    public function pull($params = null)
    {
        $ret = new Action();
        try {
            $ret->setResult($this->getConfig()->reads($params));
            $ret->setHandled(true);
        } catch (\Exception $e) {
            if (isset($e->jtl)) {
                $ret->setHandled($e->jtl);
            } else {
                $ret->setHandled(false);
            }
            $err = new Error();
            $err->setCode($e->getCode());
            $err->setMessage($e->getMessage());
            $ret->setError($err);
        }
        return $ret;
    }

    /**
     * Writes the controller configuration and returns the result.
     *
     * @param mixed $params An array of parameters to write
     */
    public function push($params = null)
    {
        $ret = new Action();
        try {
            $ret->setResult($this->getConfig()->writes($params));
            $ret->setHandled(true);
        } catch (\Exception $e) {
            $ret->setHandled($e->jtl);
            $err = new Error();
            $err->setCode($e->getCode());
            $err->setMessage($e->getMessage());
            $ret->setError($err);
        }
        return $ret;
    }

    /**
     * Delete is not needed.
     *
     * @param mixed $params An array of parameters to write
     */
    public function delete($params = null)
    {
        return $params;
    }
}
