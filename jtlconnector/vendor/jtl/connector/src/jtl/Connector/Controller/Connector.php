<?php
/**
 *
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Application
 */

namespace jtl\Connector\Controller;

use \jtl\Connector\Core\Controller\Controller as CoreController;
use jtl\Connector\Core\System\Check;
use \jtl\Connector\Result\Action;
use \jtl\Connector\Core\Rpc\Error;
use \jtl\Connector\Application\Application;
use \jtl\Connector\Linker\IdentityLinker;
use \jtl\Connector\Serializer\JMS\SerializerBuilder;
use \jtl\Connector\Core\Logger\Logger;
use \jtl\Connector\Linker\ChecksumLinker;
use \jtl\Connector\Checksum\IChecksum;
use \jtl\Connector\Formatter\ExceptionFormatter;
use \jtl\Connector\Core\Exception\ControllerException;

/**
 * Base Config Controller
 *
 * @access public
 */
class Connector extends CoreController
{    
    /**
     * Initialize the connector.
     *
     * @param mixed $params Can be empty or not defined and a string.
     */
    public function init($params = null)
    {
        $ret = new Action();
        $ret->setHandled(true);

        try {
            Check::run();

            // Linking garbage collecting
            Application()->getConnector()->getPrimaryKeyMapper()->gc();

            $ret->setResult(true);
        } catch (\Exception $e) {
            $err = new Error();
            $err->setCode($e->getCode());
            $err->setMessage($e->getMessage());
            $ret->setError($err);
        }

        return $ret;
    }
    
    /**
     * Returns the connector features.
     *
     * @param mixed $params Can be empty or not defined and a string.
     */
    public function features($params = null)
    {
        $ret = new Action();
        try {
            //@todo: irgend ne supertolle feature list methode
            $featureData = file_get_contents(CONNECTOR_DIR . '/config/features.json');
            $features = json_decode($featureData);

            $ret->setResult($features);
            $ret->setHandled(true);
        } catch (\Exception $e) {
            $err = new Error();
            $err->setCode($e->getCode());
            $err->setMessage($e->getMessage());
            $ret->setError($err);
        }

        return $ret;
    }

    /**
     * Ack Identity Mappings
     *
     * @param mixed $params empty or ack json string.
     */
    public function ack($params = null)
    {
        $ret = new Action();
        $ret->setHandled(true);

        try {
            $serializer = SerializerBuilder::create();

            $ack = $serializer->deserialize($params, "jtl\Connector\Model\Ack", 'json');

            $identityLinker = IdentityLinker::getInstance();

            foreach ($ack->getIdentities() as $modelName => $identities) {
                foreach ($identities as $identity) {
                    $identityLinker->save($identity->getEndpoint(), $identity->getHost(), $modelName);
                }
            }

            // Checksum linking
            foreach ($ack->getChecksums() as $checksum) {
                if ($checksum instanceof IChecksum) {
                    if (!ChecksumLinker::save($checksum)) {
                        Logger::write(sprintf('Could not save checksum for endpoint (%s), host (%s) and type (%s)',
                            $checksum->getForeignKey()->getEndpoint(), 
                            $checksum->getForeignKey()->getHost(),
                            $checksum->getType()
                        ), Logger::WARNING, 'checksum');
                    }
                }
            }

            $ret->setResult(true);            
        } catch (\Exception $e) {
            $err = new Error();
            $err->setCode($e->getCode());
            $err->setMessage($e->getMessage());
            $ret->setError($err);
        }

        return $ret;
    }

    /**
     * Returns the connector auth action
     *
     * @param mixed $params
     * @return \jtl\Connector\Result\Action
     */
    public function auth($params)
    {
        try {
            $token = Application()->getConnector()->getTokenLoader()->load();
        } catch (\Exception $e) {
            Logger::write(ExceptionFormatter::format($e), Logger::ERROR, 'security');
            $token = '';
        }

        $action = new Action();
        $action->setHandled(true);
        $authRequest = null;

        try {
            $serializer = SerializerBuilder::create();

            $authRequest = $serializer->deserialize($params, "jtl\Connector\Core\Model\AuthRequest", 'json');
        } catch (\Exception $e) {
            $err = new Error();
            $err->setCode($e->getCode());
            $err->setMessage($e->getMessage());
            $action->setError($err);

            return $action;
        }

        // If credentials are not valid, return appropriate response
        if ($token !== $authRequest->getToken()) {
            sleep(2);

            $error = new Error();
            $error->setCode(790);
            $error->setMessage("Could not authenticate access to the connector");
            $action->setError($error);

            Logger::write(sprintf("Unauthorized access with token (%s) from ip (%s)", $authRequest->getToken(), $_SERVER['REMOTE_ADDR']), Logger::INFO, 'security');

            return $action;
        }

        if (Application()->getSession() !== null) {
            $session = new \stdClass();
            $session->sessionId = Application()->getSession()->getSessionId();
            $session->lifetime = Application()->getSession()->getLifetime();
            
            $action->setResult($session);
        } else {
            $error = new Error();
            $error->setCode(789)
                ->setMessage("Could not get any Session");
            $action->setError($error);
        }
        
        return $action;
    }
}
