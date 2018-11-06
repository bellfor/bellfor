<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Linker
 */
namespace jtl\Connector\Linker;

use \jtl\Connector\Mapper\IPrimaryKeyMapper;
use \jtl\Connector\Model\DataModel;
use \jtl\Connector\Exception\LinkerException;
use \jtl\Connector\Model\Identity;
use \jtl\Connector\Core\Logger\Logger;
use \jtl\Connector\Drawing\ImageRelationType;

/**
 * Identity Connector Linker
 *
 * @access public
 * @author Daniel Böhmer <daniel.boehmer@jtl-software.com>
 */
class IdentityLinker
{
    const CACHE_TYPE_HOST = 'h';
    const CACHE_TYPE_ENDPOINT = 'e';

    const TYPE_CATEGORY = 1;
    const TYPE_CUSTOMER = 2;
    const TYPE_CUSTOMER_ORDER = 4;
    const TYPE_DELIVERY_NOTE = 8;
    const TYPE_IMAGE = 16;
    const TYPE_MANUFACTURER = 32;
    const TYPE_PRODUCT = 64;
    const TYPE_SPECIFIC = 128;
    const TYPE_SPECIFIC_VALUE = 256;
    const TYPE_PAYMENT = 512;
    const TYPE_CROSSSELLING = 1024;
    const TYPE_CROSSSELLING_GROUP = 2048;

    /**
     * Session Database Mapper
     *
     * @var \jtl\Connector\Core\Database\IDatabase
     */
    protected static $mapper;
    public static $useCache;
    protected static $cache = array();
    protected static $instance;

    protected static $types = array(
        'Category' => self::TYPE_CATEGORY,
        'Customer' => self::TYPE_CUSTOMER,
        'CustomerOrder' => self::TYPE_CUSTOMER_ORDER,
        'DeliveryNote' => self::TYPE_DELIVERY_NOTE,
        'Image' => self::TYPE_IMAGE,
        'Manufacturer' => self::TYPE_MANUFACTURER,
        'Product' => self::TYPE_PRODUCT,
        'Specific' => self::TYPE_SPECIFIC,
        'SpecificValue' => self::TYPE_SPECIFIC_VALUE,
        'Payment' => self::TYPE_PAYMENT,
        'CrossSelling' => self::TYPE_CROSSSELLING,
        'CrossSellingItem' => self::TYPE_CROSSSELLING,
        'CrossSellingGroup' => self::TYPE_CROSSSELLING_GROUP
    );

    protected static $mappings = array(
        'Category' => array(
            'id' => self::TYPE_CATEGORY,
            'parentCategoryId' => self::TYPE_CATEGORY
        ),
        'CategoryI18n' => array(
            'categoryId' => self::TYPE_CATEGORY
        ),
        'ProductPrice' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'Manufacturer' => array(
            'id' => self::TYPE_MANUFACTURER
        ),
        'ManufacturerI18n' => array(
            'manufacturerId' => self::TYPE_MANUFACTURER
        ),
        'Customer' => array(
            'id' => self::TYPE_CUSTOMER
        ),
        'CustomerAttr' => array(
            'customerId' => self::TYPE_CUSTOMER
        ),
        'CustomerOrder' => array(
            'id' => self::TYPE_CUSTOMER_ORDER,
            'customerId' => self::TYPE_CUSTOMER
        ),
        'CustomerOrderAttr' => array(
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        ),
        'CustomerOrderBillingAddress' => array(
            'customerId' => self::TYPE_CUSTOMER
        ),
        'CustomerOrderShippingAddress' => array(
            'customerId' => self::TYPE_CUSTOMER
        ),
        'CustomerOrderPaymentInfo' => array(
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        ),
        'Product' => array(
            'id' => self::TYPE_PRODUCT,
            'masterProductId' => self::TYPE_PRODUCT,
            'manufacturerId' => self::TYPE_MANUFACTURER
        ),
        'ProductSpecialPrice' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductSpecific' => array(
            'id' => self::TYPE_SPECIFIC,
            'productId' => self::TYPE_PRODUCT,
            'specificValueId' => self::TYPE_SPECIFIC_VALUE
        ),
        'DeliveryNote' => array(
            'id' => self::TYPE_DELIVERY_NOTE,
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        ),
        'DeliveryNoteItem' => array(
            'deliveryNoteId' => self::TYPE_DELIVERY_NOTE
        ),
        'CategoryInvisibility' => array(
            'categoryId' => self::TYPE_CATEGORY
        ),
        'CategoryCustomerGroup' => array(
            'categoryId' => self::TYPE_CATEGORY
        ),
        'CategoryAttr' => array(
            'categoryId' => self::TYPE_CATEGORY
        ),
        'ProductFileDownload' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'Product2Category' => array(
            'productId' => self::TYPE_PRODUCT,
            'categoryId' => self::TYPE_CATEGORY
        ),
        'MediaFile' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductConfigGroup' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductInvisibility' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'CrossSelling' => array(
            'id' => self::TYPE_CROSSSELLING,
            'productId' => self::TYPE_PRODUCT
        ),
        'CrossSellingItem' => array(
            'crossSellingGroupId' => self::TYPE_CROSSSELLING_GROUP,
            'productIds' => self::TYPE_PRODUCT  // List of Product identities
        ),
        'CrossSellingGroup' => array(
            'id' => self::TYPE_CROSSSELLING_GROUP
        ),
        'PartsList' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductVariation' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'CustomerOrderItem' => array(
            'productId' => self::TYPE_PRODUCT,
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        ),
        'ConfigItem' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductI18n' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductFunctionAttr' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'FileUpload' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductWarehouseInfo' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'FileDownloadHistory' => array(
            'customerId' => self::TYPE_CUSTOMER,
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        ),
        'ProductVarCombination' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductAttr' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'ProductStockLevel' => array(
            'productId' => self::TYPE_PRODUCT
        ),
        'Shipment' => array(
            'deliveryNoteId' => self::TYPE_DELIVERY_NOTE
        ),
        'Image' => array(
            'id' => self::TYPE_IMAGE,
            'foreignKey' => self::TYPE_IMAGE
        ),
        'CategoryFunctionAttr' => array(
            'categoryId' => self::TYPE_CATEGORY
        ),
        'CustomerOrderBasket' => array(
            'customerId' => self::TYPE_CUSTOMER
        ),
        'Specific' => array(
            'id' => self::TYPE_SPECIFIC
        ),
        'SpecificI18n' => array(
            'specificId' => self::TYPE_SPECIFIC
        ),
        'SpecificValue' => array(
            'id' => self::TYPE_SPECIFIC_VALUE,
            'specificId' => self::TYPE_SPECIFIC
        ),
        'SpecificValueI18n' => array(
            'specificValueId' => self::TYPE_SPECIFIC_VALUE
        ),
        'StatusChange' => array(
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        ),
        'Payment' => array(
            'id' => self::TYPE_PAYMENT,
            'customerOrderId' => self::TYPE_CUSTOMER_ORDER
        )
    );

    protected $runtimeInfos = array();

    /**
     * Singleton
     *
     * @param boolean $useCache
     * @return \jtl\Connector\Linker\IdentityLinker
     */
    public static function getInstance($useCache = true)
    {
        if (self::$instance === null) {
            self::$instance = new self($useCache);
        } else {
            self::$instance->useCache($useCache);
        }
        
        return self::$instance;
    }

    /**
     * Constructor
     *
     * @param boolean $useCache
     */
    protected function __construct($useCache = true)
    {
        self::$useCache = (bool)$useCache;
    }

    /**
     * Constructor
     *
     * @param boolean $useCache
     * @return \jtl\Connector\Linker\IdentityLinker
     */
    public function useCache($useCache)
    {
        self::$useCache = (bool)$useCache;
    }

    /**
     * Database setter
     *
     * @param \jtl\Connector\Mapper\IPrimaryKeyMapper $mapper
     */
    public function setPrimaryKeyMapper(IPrimaryKeyMapper $mapper)
    {
        self::$mapper = $mapper;
    }

    /**
     * Database setter
     *
     * @param \jtl\Connector\Model\DataModel $model
     * @param bool $isDeleted
     * @throws \jtl\Connector\Exception\LinkerException
     */
    public function linkModel(DataModel &$model, $isDeleted = false)
    {
        $reflect = new \ReflectionClass($model);

        // Image work around
        if (isset($this->runtimeInfos['relationType'])) {
            unset($this->runtimeInfos['relationType']);
        }

        if ($reflect->getShortName() === 'Image' && method_exists($model, 'getRelationType')) {
            $this->runtimeInfos['relationType'] = $model->getRelationType();
        }

        foreach ($model->getModelType()->getProperties() as $propertyInfo) {
            $property = ucfirst($propertyInfo->getName());
            $setter = 'set' . $property;
            $getter = 'get' . $property;

            if ($propertyInfo->isNavigation() && $model->{$getter}() !== null) {
                if (is_array($model->{$getter}())) {
                    $list = $model->{$getter}();
                    foreach ($list as &$entity) {
                        if ($entity instanceof DataModel) {
                            $this->linkModel($entity, $isDeleted);
                        } elseif ($entity instanceof Identity && $this->isType($reflect->getShortName(), $property)) {
                            $this->linkIdentityList($entity, $reflect->getShortName(), $property, $isDeleted);
                        } else {
                            Logger::write(
                                sprintf('Property (%s) from model (%s) is not an instance of DataModel or Identity', $propertyInfo->getName(), $reflect->getShortName()),
                                Logger::WARNING, 'linker'
                            );
                        }
                    }
                } elseif ($model->{$getter}() instanceof DataModel) {
                    $entity = $model->{$getter}();
                    $this->linkModel($entity, $isDeleted);
                } else {
                    Logger::write(
                        sprintf('Property (%s) from model (%s) is not an array or an instance of DataModel', $propertyInfo->getName(), $reflect->getShortName()),
                        Logger::WARNING, 'linker'
                    );
                }
            } elseif ($propertyInfo->isIdentity() && $this->isType($reflect->getShortName(), $property)) {
                $identity = $model->{$getter}();

                if (!($identity instanceof Identity)) {
                    continue;
                }

                if (strlen($identity->getEndpoint()) > 0 && $identity->getHost() > 0) {
                    if ($isDeleted) {
                        $this->delete($identity->getEndpoint(), $identity->getHost(), $reflect->getShortName());
                    } elseif (!$this->exists(null, $identity->getHost(), $reflect->getShortName(), $property, true)) {
                        $this->save($identity->getEndpoint(), $identity->getHost(), $reflect->getShortName(), $property);
                    }

                    continue;
                } else {
                    if ($identity->getHost() > 0) {
                        if ($isDeleted) {
                            $this->delete(null, $identity->getHost(), $reflect->getShortName());
                        } elseif ($this->exists(null, $identity->getHost(), $reflect->getShortName(), $property)) {
                            $identity->setEndpoint($this->getEndpointId($identity->getHost(), $reflect->getShortName(), $property));

                            $model->{$setter}($identity);
                        }
                    } elseif (strlen($identity->getEndpoint()) > 0) {
                        if ($isDeleted) {
                            $this->delete($identity->getEndpoint(), null, $reflect->getShortName());
                        } elseif ($this->exists($identity->getEndpoint(), null, $reflect->getShortName(), $property)) {
                            $identity->setHost($this->getHostId($identity->getEndpoint(), $reflect->getShortName(), $property));

                            $model->{$setter}($identity);
                        }
                    }
                }
            }
        }
    }

    /**
     * Linker for identity lists
     *
     * @param \jtl\Connector\Model\Identity $identity
     * @param string $modelName
     * @param string $property
     * @param bool $isDeleted
     * @throws \jtl\Connector\Exception\LinkerException
     */
    public function linkIdentityList(Identity &$identity, $modelName, $property, $isDeleted = false)
    {
        if (strlen($identity->getEndpoint()) > 0 && $identity->getHost() > 0) {
            if ($isDeleted) {
                $this->delete($identity->getEndpoint(), $identity->getHost(), $modelName);
            } elseif (!$this->exists(null, $identity->getHost(), $modelName, $property, true)) {
                $this->save($identity->getEndpoint(), $identity->getHost(), $modelName, $property);
            }
        } else {
            if ($identity->getHost() > 0) {
                if ($isDeleted) {
                    $this->delete(null, $identity->getHost(), $modelName);
                } elseif ($this->exists(null, $identity->getHost(), $modelName, $property)) {
                    $identity->setEndpoint($this->getEndpointId($identity->getHost(), $modelName, $property));
                }
            } elseif (strlen($identity->getEndpoint()) > 0) {
                if ($isDeleted) {
                    $this->delete($identity->getEndpoint(), null, $modelName);
                } elseif ($this->exists($identity->getEndpoint(), null, $modelName, $property)) {
                    $identity->setHost($this->getHostId($identity->getEndpoint(), $modelName, $property));
                }
            }
        }
    }

    /**
     * Type id getter
     *
     * @param string $modelName
     * @param string $property
     * @throws \jtl\Connector\Exception\LinkerException
     * @return int
     */
    public function getType($modelName, $property = null)
    {
        // Work around
        if ($modelName === 'Image' && $property === 'ForeignKey' && isset($this->runtimeInfos['relationType'])) {
            switch ($this->runtimeInfos['relationType']) {
                case ImageRelationType::TYPE_PRODUCT:
                    return self::TYPE_PRODUCT;
                    break;
                case ImageRelationType::TYPE_CATEGORY:
                    return self::TYPE_CATEGORY;
                    break;
                case ImageRelationType::TYPE_SPECIFIC:
                    return self::TYPE_SPECIFIC;
                    break;
                case ImageRelationType::TYPE_MANUFACTURER:
                    return self::TYPE_MANUFACTURER;
                    break;
            }
        }

        $modelName = ucfirst($modelName);

        if ($property === null) {
            if (!isset(self::$types[$modelName])) {
                throw new LinkerException(sprintf('Type for model (%s) not found', $modelName));
            }

            return self::$types[$modelName];
        }

        $property = lcfirst($property);

        if (!isset(self::$mappings[$modelName])) {
            throw new LinkerException(sprintf('Type for model (%s) not found', $modelName));
        }

        if (!isset(self::$mappings[$modelName][$property])) {
            throw new LinkerException(sprintf('Type for model (%s) and property (%s) not found', $modelName, $property));
        }

        return self::$mappings[$modelName][$property];
    }

    /**
     * Type id getter
     *
     * @param string $modelName
     * @param string $property
     * @return boolean
     */
    public function isType($modelName, $property = null)
    {
        $modelName = ucfirst($modelName);
        $property = lcfirst($property);

        return ($property === null) ? isset(self::$types[$modelName]) : isset(self::$mappings[$modelName][$property]);
    }

    /**
     * Model name getter
     *
     * @param int $type
     * @throws \jtl\Connector\Exception\LinkerException
     * @return string
     */
    public function getModelName($type)
    {
        $modelName = array_search($type, self::$types);
        if ($modelName === false) {
            throw new LinkerException(sprintf('Model for type (%s) not found', $type));
        }

        return $modelName;
    }

    /**
     * Checks if link exists
     *
     * @param string $endpointId
     * @param integer $hostId
     * @param string $modelName
     * @param string $property
     * @param boolean $notNull
     * @throws \jtl\Connector\Exception\LinkerException
     */
    public function exists($endpointId = null, $hostId = null, $modelName, $property, $notNull = false)
    {
        if ($endpointId === null && $hostId === null) {
            throw new LinkerException('Both parameters (endpointId, hostId) can not be null');
        }

        $type = $this->getType($modelName, $property);

        $id = null;
        $cacheType = null;
        if ($endpointId !== null) {
            $id = $endpointId;
            $cacheType = self::CACHE_TYPE_ENDPOINT;
        } elseif ($hostId !== null) {
            $id = $hostId;
            $cacheType = self::CACHE_TYPE_HOST;
        }

        if ($this->checkCache($id, $type, $cacheType, $notNull)) {
            return true;
        }

        if ($endpointId !== null) {
            $hostId = self::$mapper->getHostId($endpointId, $type);
        } elseif ($hostId !== null) {
            $relationType = isset($this->runtimeInfos['relationType']) ? $this->runtimeInfos['relationType'] : null;
            $endpointId = self::$mapper->getEndpointId($hostId, $type, $relationType);
        }

        if ($notNull && $endpointId === null) {
            return false;
        }

        //if ($endpointId !== null && $hostId !== null) {
            $this->saveCache($endpointId, $hostId, $type, $cacheType);

            return true;
        //}

        return false;
    }

    /**
     * Save link to database
     *
     * @param string $endpointId
     * @param integer $hostId
     * @param string $modelName
     * @param string $property
     * @return boolean
     * @throws \jtl\Connector\Exception\LinkerException
     */
    public function save($endpointId, $hostId, $modelName, $property = null)
    {
        $type = $this->getType($modelName, $property);

        $result = self::$mapper->save($endpointId, $hostId, $type);
        if ($result) {
            $this->saveCache($endpointId, $hostId, $type, self::CACHE_TYPE_ENDPOINT);
            $this->saveCache($endpointId, $hostId, $type, self::CACHE_TYPE_HOST);

            return true;
        }

        return false;
    }

    /**
     * Delete link from database
     *
     * @param string $endpointId
     * @param integer $hostId
     * @param string $modelName
     * @return boolean
     */
    public function delete($endpointId = null, $hostId = null, $modelName)
    {
        $type = $this->getType($modelName);

        $result = self::$mapper->delete($endpointId, $hostId, $type);
        if ($result) {
            $this->deleteCache($endpointId, null, $type, self::CACHE_TYPE_ENDPOINT);
            $this->deleteCache(null, $hostId, $type, self::CACHE_TYPE_HOST);

            return true;
        }

        return false;
    }

    /**
     * Clears the entire link table
     *
     * @return boolean
     */
    public function clear()
    {
        return self::$mapper->clear();
    }

    /**
     * Endpoint ID getter
     *
     * @param integer $hostId
     * @param string $modelName
     * @param string $property
     */
    public function getEndpointId($hostId, $modelName, $property)
    {
        $type = $this->getType($modelName, $property);

        if (($endpointId = $this->loadCache($hostId, $type, self::CACHE_TYPE_HOST)) !== false) {
        //if (($endpointId = $this->loadCache($hostId, $type, self::CACHE_TYPE_HOST)) !== null) {
            return $endpointId;
        }

        $relationType = isset($this->runtimeInfos['relationType']) ? $this->runtimeInfos['relationType'] : null;
        $endpointId = self::$mapper->getEndpointId($hostId, $type, $relationType);

        //if ($endpointId !== null) {
            $this->saveCache($endpointId, $hostId, $type, self::CACHE_TYPE_HOST);

            return $endpointId;
        //}

        return null;
    }

    /**
     * Host ID getter
     *
     * @param string $endpointId
     * @param string $modelName
     * @param string $property
     */
    public function getHostId($endpointId, $modelName, $property)
    {
        $type = $this->getType($modelName, $property);

        if (($hostId = $this->loadCache($endpointId, $type, self::CACHE_TYPE_ENDPOINT)) !== false) {
        //if (($hostId = $this->loadCache($endpointId, $type, self::CACHE_TYPE_ENDPOINT)) !== null) {
            return $hostId;
        }

        $hostId = self::$mapper->getHostId($endpointId, $type);

        //if ($hostId !== null) {
            $this->saveCache($endpointId, $hostId, $type, self::CACHE_TYPE_ENDPOINT);

            return $hostId;
        //}

        return null;
    }

    protected function checkCache($id, $type, $cacheType, $notNull = false)
    {
        //return (self::$useCache && array_key_exists($this->buildKey($id, $type, $cacheType), self::$cache));
        //return (self::$useCache && isset(self::$cache[$this->buildKey($id, $type, $cacheType)]));
        return (self::$useCache && array_key_exists($this->buildKey($id, $type, $cacheType), self::$cache)
            && (!$notNull || self::$cache[$this->buildKey($id, $type, $cacheType)] !== null));
    }

    protected function loadCache($id, $type, $cacheType)
    {
        return $this->checkCache($id, $type, $cacheType) ? self::$cache[$this->buildKey($id, $type, $cacheType)] : false;
        //return $this->checkCache($id, $type, $cacheType) ? self::$cache[$this->buildKey($id, $type, $cacheType)] : null;
    }

    protected function saveCache($endpointId, $hostId, $type, $cacheType)
    {
        if (self::$useCache) {
            switch ($cacheType) {
                case self::CACHE_TYPE_ENDPOINT:
                    self::$cache[$this->buildKey($endpointId, $type, $cacheType)] = $hostId;
                    break;
                case self::CACHE_TYPE_HOST:
                    self::$cache[$this->buildKey($hostId, $type, $cacheType)] = $endpointId;
                    break;
            }
        }
    }

    protected function deleteCache($endpointId = null, $hostId = null, $type, $cacheType)
    {
        if (self::$useCache) {
            switch ($cacheType) {
                case self::CACHE_TYPE_ENDPOINT:
                    unset(self::$cache[$this->buildKey($endpointId, $type, $cacheType)]);
                    break;
                case self::CACHE_TYPE_HOST:
                    unset(self::$cache[$this->buildKey($hostId, $type, $cacheType)]);
                    break;
            }
        }
    }

    protected function buildKey($id, $type, $cacheType)
    {
        return sprintf('%s_%s_%s', $cacheType, $id, $type);
    }

    public static function getCache()
    {
        return self::$cache;
    }
}
