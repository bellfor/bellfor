<?php
/**
 * @copyright 2010-2015 JTL-Software GmbH
 * @package jtl\Connector\Model
 * @subpackage Product
 */

namespace jtl\Connector\Model;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 *
 * @access public
 * @package jtl\Connector\Model
 * @subpackage Product
 * 
 * @Serializer\AccessType("public_method")
 */
class Image extends DataModel
{
    /**
     * @var Identity 
     * @Serializer\Type("jtl\Connector\Model\Identity")
     * @Serializer\SerializedName("foreignKey")
     * @Serializer\Accessor(getter="getForeignKey",setter="setForeignKey")
     */
    protected $foreignKey = null;

    /**
     * @var Identity 
     * @Serializer\Type("jtl\Connector\Model\Identity")
     * @Serializer\SerializedName("id")
     * @Serializer\Accessor(getter="getId",setter="setId")
     */
    protected $id = null;

    /**
     * @var string 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("filename")
     * @Serializer\Accessor(getter="getFilename",setter="setFilename")
     */
    protected $filename = '';

    /**
     * @var ImageRelationType 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("relationType")
     * @Serializer\Accessor(getter="getRelationType",setter="setRelationType")
     */
    protected $relationType = '';

    /**
     * @var string 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("remoteUrl")
     * @Serializer\Accessor(getter="getRemoteUrl",setter="setRemoteUrl")
     */
    protected $remoteUrl = '';

    /**
     * @var integer 
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("sort")
     * @Serializer\Accessor(getter="getSort",setter="setSort")
     */
    protected $sort = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->foreignKey = new Identity();
        $this->id = new Identity();
    }

    /**
     * @param Identity $foreignKey 
     * @return \jtl\Connector\Model\Image
     * @throws \InvalidArgumentException if the provided argument is not of type 'Identity'.
     */
    public function setForeignKey(Identity $foreignKey)
    {
        return $this->setProperty('foreignKey', $foreignKey, 'Identity');
    }

    /**
     * @return Identity 
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @param Identity $id 
     * @return \jtl\Connector\Model\Image
     * @throws \InvalidArgumentException if the provided argument is not of type 'Identity'.
     */
    public function setId(Identity $id)
    {
        return $this->setProperty('id', $id, 'Identity');
    }

    /**
     * @return Identity 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $filename 
     * @return \jtl\Connector\Model\Image
     */
    public function setFilename($filename)
    {
        return $this->setProperty('filename', $filename, 'string');
    }

    /**
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param ImageRelationType $relationType 
     * @return \jtl\Connector\Model\Image
     */
    public function setRelationType($relationType)
    {
        return $this->setProperty('relationType', $relationType, 'string');
    }

    /**
     * @return string 
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * @param string $remoteUrl 
     * @return \jtl\Connector\Model\Image
     */
    public function setRemoteUrl($remoteUrl)
    {
        return $this->setProperty('remoteUrl', $remoteUrl, 'string');
    }

    /**
     * @return string 
     */
    public function getRemoteUrl()
    {
        return $this->remoteUrl;
    }

    /**
     * @param integer $sort 
     * @return \jtl\Connector\Model\Image
     */
    public function setSort($sort)
    {
        return $this->setProperty('sort', $sort, 'integer');
    }

    /**
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }
}
