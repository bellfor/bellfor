<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller\Product;

use jtl\Connector\Model\Product as ProductModel;
use jtl\Connector\Model\ProductAttr as ProductAttribute;
use jtl\Connector\OpenCart\Controller\BaseController;
use jtl\Connector\OpenCart\Utility\SQLs;

class ProductAttr extends BaseController
{
    public function pullData(array $data, $model, $limit = null)
    {
        return parent::pullDataDefault($data);
    }

    protected function pullQuery(array $data, $limit = null)
    {
        return SQLs::productAttributePull($data['product_id']);
    }

    public function pushData(ProductModel $data, &$model)
    {
        $attributes = [];
        $model['product_attribute'] = [];
        foreach ($data->getAttributes() as $attr) {
            if (!$attr->getIsCustomProperty()) {
                list($values, $descriptions) = $this->buildI18ns($attr);
                $attributeId = $this->getOrCreateAttribute($descriptions);
                if (!in_array($attributeId, $attributes)) {
                    $model['product_attribute'][] = [
                        'attribute_id' => $attributeId,
                        'product_attribute_description' => $values
                    ];
                    $attributes[] = $attributeId;
                }
            }
        }
    }

    /**
     * Build for each of the internationalized product attributes the OpenCart specific attribute_description =>
     * descriptions and product_attribute_description => values.
     */
    private function buildI18ns(ProductAttribute $attr)
    {
        $values = [];
        $descriptions = [];
        foreach ($attr->getI18ns() as $i18n) {
            $languageId = $this->utils->getLanguageId($i18n->getLanguageISO());
            if (!is_null($languageId)) {
                $values[intval($languageId)] = [
                    'text' => $i18n->getValue()
                ];
                $descriptions[intval($languageId)] = [
                    'name' => $i18n->getName()
                ];
            }
        }
        return array($values, $descriptions);
    }

    /**
     * Check if there is already an attribute existing based on its descriptions.
     */
    private function getOrCreateAttribute(array $descriptions)
    {
        $attributeId = null;
        foreach ($descriptions as $languageId => $desc) {
            $attributeId = $this->database->queryOne(SQLs::attributeId($languageId, $desc['name']));
            if (!is_null($attributeId)) {
                break;
            }
        }
        if (is_null($attributeId)) {
            $groupId = $this->oc->getConfig(\ControllerModuleJtlconnector::CONFIG_ATTRIBUTE_GROUP);
            $ocAttribute = $this->oc->loadAdminModel('catalog/attribute');
            if ($ocAttribute instanceof \ModelCatalogAttribute) {
                $attributeId = $ocAttribute->addAttribute([
                    'sort_order' => 0,
                    'attribute_group_id' => $groupId,
                    'attribute_description' => $descriptions
                ]);
            }
        }
        return $attributeId;
    }
}