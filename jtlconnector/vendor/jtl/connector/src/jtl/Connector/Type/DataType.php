<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Model
 */

namespace jtl\Connector\Type;

use jtl\Connector\Type\PropertyInfo;

/**
 * Entity data model
 *
 * @access public
 * @package jtl\Connector\Type
 */
abstract class DataType
{
    /**
     * List of PropertyInfos
     * @var \jtl\Connector\Type\PropertyInfo[]
     */
    private $_propertyInfo = null;

    /**
     * Returns all the public properties of the current Type.
     *
     * @return jtl\Connector\Type\PropertyInfo
     */
    public function getProperties()
    {
        if ($this->_propertyInfo === null) {
            $this->_propertyInfo = $this->loadProperties();
        }
            
        return $this->_propertyInfo;
    }
    
    /**
     * Searches for the public property with the specified name.
     *
     * @param string $propertyName
     * @return jtl\Connector\Type\PropertyInfo
     */
    public function getProperty($propertyName)
    {
        foreach ($this->getProperties() as $property) {
            if ($property->getName() == $propertyName) {
                return $property;
            }
        }
        
        return null;
    }
    
    abstract protected function loadProperties();
    abstract public function isMain();
}
