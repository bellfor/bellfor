<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Utility;

use jtl\Connector\Linker\IdentityLinker;

defined('DB_PREFIX') || define('DB_PREFIX', 'oc_');

final class SQLs
{
    // <editor-fold defaultstate="collapsed" desc="Attribute">
    public static function attributeId($languageId, $name)
    {
        return sprintf('
            SELECT a.attribute_id
            FROM ' . DB_PREFIX . 'attribute a
            LEFT JOIN ' . DB_PREFIX . 'attribute_description ad ON a.attribute_id = ad.attribute_id
            WHERE ad.language_id = %d AND ad.name = "%s"',
            $languageId, $name
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Category">
    public static function categoryPull($limit)
    {
        return sprintf('
            SELECT c.*
            FROM ' . DB_PREFIX . 'category c
            LEFT JOIN jtl_connector_category_level cl ON cl.category_id = c.category_id
            LEFT JOIN jtl_connector_link l ON c.category_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            ORDER BY cl.level ASC
            LIMIT %d',
            IdentityLinker::TYPE_CATEGORY, $limit
        );
    }

    public static function categoryI18n($categoryId)
    {
        return sprintf('
            SELECT c.*, l.code
            FROM ' . DB_PREFIX . 'category_description c
            LEFT JOIN ' . DB_PREFIX . 'language l ON c.language_id = l.language_id
            WHERE c.category_id = %d',
            $categoryId
        );
    }

    public static function categoryStats()
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'category c
            LEFT JOIN jtl_connector_link l ON c.category_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL',
            IdentityLinker::TYPE_CATEGORY
        );
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Checksum">
    public static function checksumRead($endpointId, $type)
    {
        return sprintf('
            SELECT checksum
            FROM jtl_connector_checksum
            WHERE endpointId = %d AND type = %d',
            $endpointId, $type
        );
    }

    public static function checksumWrite($endpointId, $type, $checksum)
    {
        return sprintf('
            INSERT IGNORE INTO jtl_connector_checksum (endpointId, type, checksum)
            VALUES (%d, %d, "%s")',
            $endpointId, $type, $checksum
        );
    }

    public static function checksumDelete($endpointId, $type)
    {
        return sprintf('
            DELETE FROM jtl_connector_checksum
            WHERE endpointId = %d AND type = %d',
            $endpointId, $type
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cross Selling">
    public static function crossSellingPull($limit)
    {
        return sprintf('
            SELECT DISTINCT(pr.product_id) as id, DISTINCT(pr.product_id)
            FROM ' . DB_PREFIX . 'product_related pr
            LEFT JOIN jtl_connector_link l ON pr.product_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_CROSSSELLING, $limit
        );
    }

    public static function crossSellingPush($productId, $relatedId)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'product_related (product_id, related_id)
            VALUES (%d, %d)',
            $productId, $relatedId
        );
    }

    public static function crossSellingDelete($productId)
    {
        return sprintf('DELETE FROM ' . DB_PREFIX . 'product_related WHERE product_id = %d', $productId);
    }

    public static function crossSellingStats()
    {
        return sprintf('
            SELECT COUNT(DISTINCT(pr.product_id))
            FROM ' . DB_PREFIX . 'product_related pr
            LEFT JOIN jtl_connector_link l ON pr.product_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL',
            IdentityLinker::TYPE_CROSSSELLING
        );
    }

    public static function crossSellingItemPull($productId)
    {
        return sprintf('SELECT related_id FROM ' . DB_PREFIX . 'product_related  WHERE product_id = %d', $productId);
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Customer">

    public static function customerPull($limit)
    {
        return sprintf('
            SELECT c.*, a.company, a.address_1, a.city, a.postcode, a.country_id, co.iso_code_2 as country_iso, z.name
             as state
            FROM ' . DB_PREFIX . 'customer c
            LEFT JOIN ' . DB_PREFIX . 'address a ON c.address_id = a.address_id
            LEFT JOIN ' . DB_PREFIX . 'country co ON a.country_id = co.country_id
            LEFT JOIN ' . DB_PREFIX . 'zone z ON a.zone_id = z.zone_id
            LEFT JOIN jtl_connector_link l ON c.customer_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_CUSTOMER, $limit
        );
    }

    /*
    public static function customerPull($limit)
    {
        return sprintf('
                        SELECT c.*, IF(a.company<>\'\',a.company, o.payment_company) as company, 
			IF(a.address_1<>\'\',a.address_1, o.payment_address_1) as address_1,
			IF(a.city<>\'\',a.city, o.payment_city) as city,
			IF(a.postcode<>\'\',a.postcode, o.payment_postcode) as postcode,
			IF(a.country_id<>\'\',a.country_id, o.payment_country_id) as country_id,
			IF(a.address_1<>\'\',a.address_1, o.payment_address_1) as address_1,
			IF(a.address_1<>\'\',a.address_1, o.payment_address_1) as address_1,
			IF(co.iso_code_2 IS NULL ,co2.iso_code_2, co.iso_code_2) as country_iso,
			IF(z.name IS NULL, z2.name, z.name) as state
            FROM ' . DB_PREFIX . 'customer c
            LEFT JOIN ' . DB_PREFIX . 'address a ON c.customer_id = a.customer_id
             AND (
                a.address_id = ( 
                    SELECT MIN( address_id ) 
                    FROM ' . DB_PREFIX . 'address adr2
                    WHERE adr2.customer_id = c.customer_id 
                    ) 
                OR
                    a.address_id IS NULL 
                )
            LEFT JOIN ' . DB_PREFIX . 'country co ON a.country_id = co.country_id
            LEFT JOIN ' . DB_PREFIX . 'zone z ON a.zone_id = z.zone_id
			LEFT JOIN ' . DB_PREFIX . 'order o ON c.customer_id = o.customer_id 
                AND 
                    (
                    o.order_id = ( 
                        SELECT MAX( order_id ) 
                        FROM ' . DB_PREFIX . 'order order_2
                        WHERE order_2.customer_id = c.customer_id 
                        ) 
                    OR
                        o.order_id IS NULL 
                    )
			
			LEFT JOIN ' . DB_PREFIX . 'country co2 ON o.payment_country_id = co2.country_id
			LEFT JOIN ' . DB_PREFIX . 'zone z2 ON o.payment_zone_id = z2.zone_id
			
			LEFT JOIN jtl_connector_link l ON c.customer_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL

			 LIMIT %d',
            IdentityLinker::TYPE_CUSTOMER, $limit
        );
    }*/

    public static function freeFieldVatId()
    {
        return '
            SELECT DISTINCT(custom_field_id)
            FROM ' . DB_PREFIX . 'custom_field_description
            WHERE name IN ("USt-IdNr.", "VAT number")';
    }

    public static function freeFieldTitleId()
    {
        return '
            SELECT DISTINCT(custom_field_id)
            FROM ' . DB_PREFIX . 'custom_field_description
            WHERE name IN ("Titel", "Title")';
    }

    public static function freeFieldSalutationId()
    {
        return '
            SELECT DISTINCT(custom_field_id)
            FROM ' . DB_PREFIX . 'custom_field_description
            WHERE name IN ("Anrede", "Salutation")';
    }

    public static function freeFieldValue($valueId)
    {
        return sprintf('
            SELECT name
            FROM ' . DB_PREFIX . 'custom_field_value_description
            WHERE custom_field_value_id = %d',
            $valueId
        );
    }

    public static function customerStats()
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'customer c
            LEFT JOIN jtl_connector_link l ON c.customer_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL',
            IdentityLinker::TYPE_CUSTOMER
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Customer Order">
    public static function customerOrderPull($limit)
    {
        return sprintf('
            SELECT o.*, l.code, c.iso_code_3, (o.total - ot.value) as total_sum
            FROM ' . DB_PREFIX . 'order o
            LEFT JOIN ' . DB_PREFIX . 'language l ON o.language_id = l.language_id
            LEFT JOIN ' . DB_PREFIX . 'country c ON o.payment_country_id = c.country_id
            LEFT JOIN ' . DB_PREFIX . 'order_total ot ON o.order_id = ot.order_id AND ot.code = "tax"
            LEFT JOIN jtl_connector_link cl ON o.order_id = cl.endpointId AND cl.type = %d
            WHERE cl.hostId IS NULL
            AND o.order_status_id > 0
            LIMIT %d',
            IdentityLinker::TYPE_CUSTOMER_ORDER, $limit
        );
    }

    public static function customerOrderStats()
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'order o
            LEFT JOIN jtl_connector_link l ON o.order_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            AND o.order_status_id > 0',
            IdentityLinker::TYPE_CUSTOMER_ORDER
        );
    }

    public static function customerOrderStatus($orderId)
    {
        return sprintf('
            SELECT os.name, oh.date_added
            FROM ' . DB_PREFIX . 'order o
            LEFT JOIN ' . DB_PREFIX . 'language l ON o.language_id = l.language_id
            LEFT JOIN ' . DB_PREFIX . 'order_history oh ON o.order_id = oh.order_id
            LEFT JOIN ' . DB_PREFIX . 'order_status os ON os.order_status_id = oh.order_status_id AND os.language_id = l.language_id
            WHERE oh.order_id = %d
            ORDER BY oh.date_added DESC',
            $orderId
        );
    }

    public static function customerOrderPaymentStatus($orderId, $comments)
    {
        return sprintf('
            SELECT oh.comment, oh.date_added
            FROM ' . DB_PREFIX . 'order o
            LEFT JOIN ' . DB_PREFIX . 'language l ON o.language_id = l.language_id
            LEFT JOIN ' . DB_PREFIX . 'order_history oh ON oh.order_status_id = o.order_status_id
            WHERE oh.order_id = %d AND oh.comment != "" AND oh.comment IN (%s)
            ORDER BY oh.date_added DESC
            LIMIT 1',
            $orderId, $comments
        );
    }

    public static function customerOrderPaymentCode($orderId)
    {
        return sprintf('
            SELECT payment_code
            FROM ' . DB_PREFIX . 'order
            WHERE order_id = %d 
            ORDER BY date_added DESC
            LIMIT 1',
            $orderId
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Customer Order Item">
    public static function customerOrderProducts($orderId)
    {
        return sprintf('
            SELECT op.*, p.model as sku
            FROM ' . DB_PREFIX . 'order_product op
            LEFT JOIN ' . DB_PREFIX . 'product p ON p.product_id = op.product_id
            WHERE op.order_id = %d',
            $orderId
        );
    }

    public static function customerOrderProductsTax($orderId)
    {
        return sprintf('
        SELECT op.product_id, tr.rate, op.tax FROM `oc_order_product` op
        JOIN oc_product  p ON (op.product_id = p.product_id)
        JOIN oc_tax_rule tru ON (p.tax_class_id = tru.tax_class_id)
        JOIN oc_tax_rate tr ON (tr.tax_rate_id = tru.tax_rate_id)
      
        WHERE op.order_id = %d',
            $orderId
        );
    }

    public static function customerOrderShippings($orderId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'order_total
            WHERE CODE = "shipping" AND order_id = %d',
            $orderId
        );
    }

    public static function customerOrderDiscounts($orderId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'order_total
            WHERE CODE IN ("coupon", "voucher") AND order_id = %d',
            $orderId
        );
    }

    public static function customerOrderDiscountsOwn($orderId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX .'order_total 
            WHERE (code = "coupon" OR code = "total_customer_group_discount" OR code = "klarna_fee" OR code = "reorder_discount" )
             AND order_id = %d',
            $orderId
        );
    }



    public static function customerOrderItemVariation($orderId)
    {
        return sprintf('
            SELECT oo.*, u.name AS filename, pov.price_prefix, pov.price
            FROM ' . DB_PREFIX . 'order_option oo
            LEFT JOIN ' . DB_PREFIX . 'product_option po ON oo.product_option_id = po.product_option_id
            LEFT JOIN ' . DB_PREFIX . 'option o ON o.option_id = po.option_id
            LEFT JOIN ' . DB_PREFIX . 'upload u ON u.code = oo.value
            LEFT JOIN ' . DB_PREFIX . 'product_option_value pov ON pov.product_option_value_id = oo.product_option_value_id
            WHERE oo.order_id = %d
            ORDER BY o.sort_order',
            $orderId
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Global Data">
    // <editor-fold defaultstate="collapsed" desc="Customer Group">
    public static function customerGroupPull()
    {
        return '
           SELECT cg.*, IF( cg.customer_group_id  = 1 , 1, 0 ) AS is_default
            FROM ' . DB_PREFIX .  'customer_group cg';
    }

    public static function customerGroupI18nPull($customerGroupId)
    {
        return sprintf('
            SELECT c.*, l.code
            FROM ' . DB_PREFIX . 'customer_group_description c
            LEFT JOIN ' . DB_PREFIX . 'language l ON c.language_id = l.language_id
            WHERE c.customer_group_id = %d',
            $customerGroupId
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Currency">
    public static function currencyPull()
    {
        return '
            SELECT c.*, s.key IS NOT NULL AS is_default
            FROM ' . DB_PREFIX . 'currency c
            LEFT JOIN ' . DB_PREFIX . 'setting s ON c.code = s.value
            WHERE c.status = 1';
    }

    public static function updateCurrency($currencyId, $value)
    {
        return sprintf(
            'UPDATE ' . DB_PREFIX . 'currency SET value = %f WHERE currency_id = %d',
            $currencyId, $value
        );
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Measurement Unit">
    public static function measurementUnitLengthsPull()
    {
        return 'SELECT CONCAT("l_", length_class_id) AS id, value FROM ' . DB_PREFIX . 'length_class';
    }

    public static function measurementUnitLengthsI18nPull($lengthClassId)
    {
        return sprintf('
            SELECT CONCAT("l_", lcd.length_class_id) AS length_class_id, lcd.title, l.code
            FROM ' . DB_PREFIX . 'length_class_description lcd
            LEFT JOIN ' . DB_PREFIX . 'language l ON lcd.language_id = l.language_id
            WHERE lcd.length_class_id = %d',
            $lengthClassId
        );
    }

    public static function measurementUnitWeightsPull()
    {
        return 'SELECT CONCAT("w_", weight_class_id) AS id, value FROM ' . DB_PREFIX . 'weight_class';
    }

    public static function measurementUnitWeightsI18nPull($weightClassId)
    {
        return sprintf('
            SELECT CONCAT("w_", wcd.weight_class_id) AS weight_class_id, wcd.title, l.code
            FROM ' . DB_PREFIX . 'weight_class_description wcd
            LEFT JOIN ' . DB_PREFIX . 'language l ON wcd.language_id = l.language_id
            WHERE wcd.weight_class_id = %d',
            $weightClassId
        );
    }

    public static function measurementUnitLengthId($unit)
    {
        return sprintf('
            SELECT length_class_id
            FROM ' . DB_PREFIX . 'length_class_description
            WHERE unit = "%s"',
            $unit
        );
    }

    public static function measurementUnitWeightId($unit)
    {
        return sprintf('
            SELECT weight_class_id
            FROM ' . DB_PREFIX . 'weight_class_description
            WHERE unit = "%s"',
            $unit
        );
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Shipping">
    public static function shippingMethodsPull()
    {
        return 'SELECT * FROM ' . DB_PREFIX . 'extension WHERE type = "shipping"';
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Language">
    public static function languagePull()
    {
        return '
            SELECT l.*, s.key IS NOT NULL AS is_default
            FROM ' . DB_PREFIX . 'language l
            LEFT JOIN ' . DB_PREFIX . 'setting s ON l.code = s.value
            WHERE l.status = 1';
    }

    public static function languageId($code)
    {
        return sprintf('
            SELECT language_id
            FROM ' . DB_PREFIX . 'language
            WHERE code = "%s"',
            $code
        );
    }

    // </editor-fold>
    public static function globalDataStats()
    {
        return '
            (SELECT COUNT(*) FROM ' . DB_PREFIX . 'currency) +
            (SELECT COUNT(*) FROM ' . DB_PREFIX . 'customer_group) +
            (SELECT COUNT(*) FROM ' . DB_PREFIX . 'language) +
            (SELECT COUNT(*) FROM ' . DB_PREFIX . 'tax_rate)';
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Image">
    public static function imageProductsPull($limit)
    {
        return sprintf('
            SELECT pi.image, pi.sort_order, CONCAT("p_", pi.product_id, "_", pi.product_image_id) AS id, pi.product_id AS
            foreign_key
            FROM ' . DB_PREFIX . 'product_image pi
            LEFT JOIN jtl_connector_link l ON l.endpointId = CONCAT("p_", pi.product_id, "_", pi.product_image_id)
            AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_IMAGE, $limit
        );
    }

    public static function imageProductCoverPull($limit)
    {
        return sprintf('
            SELECT p.image, 0 AS sort_order, CONCAT("p_", p.product_id) AS id, p.product_id AS foreign_key
            FROM ' . DB_PREFIX . 'product p
            LEFT JOIN jtl_connector_link l ON l.endpointId = CONCAT("p_", p.product_id) AND l.type = %d
            WHERE l.hostId IS NULL AND p.image IS NOT NULL AND p.image != ""
            LIMIT %d',
            IdentityLinker::TYPE_IMAGE, $limit
        );
    }

    public static function imageCategoryPull($limit)
    {
        return sprintf('
            SELECT c.image, c.sort_order, CONCAT("c_", c.category_id) AS id, c.category_id AS foreign_key
            FROM ' . DB_PREFIX . 'category c
            LEFT JOIN jtl_connector_link l ON l.endpointId = CONCAT("c_", c.category_id) AND l.type = %d
            WHERE l.hostId IS NULL AND c.image IS NOT NULL AND c.image != ""
            LIMIT %d',
            IdentityLinker::TYPE_IMAGE, $limit
        );
    }

    public static function imageManufacturerPull($limit)
    {
        return sprintf('
            SELECT m.image, m.sort_order, CONCAT("m_", m.manufacturer_id) AS id, m.manufacturer_id AS foreign_key
            FROM ' . DB_PREFIX . 'manufacturer m
            LEFT JOIN jtl_connector_link l ON l.endpointId = CONCAT("m_", m.manufacturer_id) AND l.type = %d
            WHERE l.hostId IS NULL AND m.image IS NOT NULL AND m.image != ""
            LIMIT %d',
            IdentityLinker::TYPE_IMAGE, $limit
        );
    }

    public static function imageProductVariationValuePull($limit)
    {
        return sprintf('
            SELECT ov.image, ov.sort_order, CONCAT("pvv_", ov.option_value_id) AS id, ov.option_value_id AS foreign_key
            FROM ' . DB_PREFIX . 'option_value ov
            LEFT JOIN jtl_connector_link l ON l.endpointId = CONCAT("pvv_", ov.option_value_id) AND l.type = %d
            WHERE l.hostId IS NULL AND ov.image IS NOT NULL AND ov.image != ""
            LIMIT %d',
            IdentityLinker::TYPE_IMAGE, $limit
        );
    }

    public static function imageCategoryPush($image, $categoryId)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'category SET image = "%s" WHERE category_id = %d',
            $image, $categoryId
        );
    }

    public static function imageManufacturerPush($image, $manufacturerId)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'manufacturer SET image = "%s" WHERE manufacturer_id = %d',
            $image, $manufacturerId
        );
    }

    public static function imageProductVariationValuePush($image, $productVariationValueId)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'option_value SET image = "%s" WHERE option_value_id = %d',
            $image, $productVariationValueId
        );
    }

    public static function imageProductDelete($imageId)
    {
        return sprintf('DELETE FROM ' . DB_PREFIX . 'product_image WHERE product_image_id = %d', $imageId);
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Manufacturer">
    public static function manufacturerPull($limit)
    {
        return sprintf('
            SELECT m.*
            FROM ' . DB_PREFIX . 'manufacturer m
            LEFT JOIN jtl_connector_link l ON m.manufacturer_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_MANUFACTURER, $limit
        );
    }

    public static function manufacturerStats()
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'manufacturer m
            LEFT JOIN jtl_connector_link l ON m.manufacturer_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL',
            IdentityLinker::TYPE_MANUFACTURER
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Module">
    public static function moduleIdTopProducts()
    {
        return 'SELECT module_id FROM ' . DB_PREFIX . 'module WHERE CODE = "featured" AND NAME = "Featured - Wawi"';
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Option">
    public static function optionId($languageId, $name, $type)
    {
        return sprintf('
            SELECT o.option_id
            FROM ' . DB_PREFIX . 'option o
            LEFT JOIN ' . DB_PREFIX . 'option_description od ON o.option_id = od.option_id
            WHERE od.language_id = %d AND od.name = "%s" AND o.type = "%s"',
            $languageId, $name, $type
        );
    }

    public static function optionValueId($languageId, $name, $optionId)
    {
        return sprintf('
            SELECT ov.option_value_id
            FROM ' . DB_PREFIX . 'option_value ov LEFT JOIN ' . DB_PREFIX . 'option_value_description ovd ON ovd.option_value_id = ov.option_value_id
            WHERE ovd.language_id = %d AND ovd.name = "%s" AND ov.option_id = %d',
            $languageId, $name, $optionId
        );
    }

    public static function obsoleteOptions()
    {
        return '
            SELECT o.option_id
            FROM ' . DB_PREFIX . 'option o
            LEFT JOIN ' . DB_PREFIX . 'product_option po ON po.option_id = o.option_id
            WHERE po.option_id IS NULL';
    }

    public static function deleteObsoleteProductOptions()
    {
        return '
            DELETE FROM oc_product_option_value pov
            LEFT JOIN oc_option_value ov ON ov.option_value_id = pov.option_value_id
            WHERE ov.option_value_id IS NULL';
    }

    public static function optionValues($optionId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'option_value ov
            LEFT JOIN ' . DB_PREFIX . 'option_value_description ovd ON ovd.option_value_id = ov.option_value_id
            WHERE ov.option_id = %d', $optionId);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Payment">

    public static function paymentPaypalPlus($limit)
    {
        return sprintf('
            SELECT o.order_id as id, o.order_id, o.date_added, o.total * o.currency_value as amount, o.payer_id as transaction_id, o.payment_code
            FROM oc_order o 
            LEFT JOIN jtl_connector_link l ON o.order_id = l.endpointId AND l.type = %d
            WHERE payment_code = \'pp_plus\'
            AND o.order_status_id = 1
            AND l.hostId IS NULL
            AND o.payer_id != \'\'
            LIMIT %d',
            IdentityLinker::TYPE_PAYMENT, $limit
        );
    }

    public static function paymentAmazonPay($limit)
    {
        return sprintf('
            SELECT a.order_id as id, a.order_id,a.date_added, a.total as amount, a.amazon_order_reference_id as transaction_id, \'amazon_login_pay\' as payment_code
            FROM oc_amazon_login_pay_order a
            LEFT JOIN jtl_connector_link l ON a.order_id = l.endpointId AND l.type = %d
            WHERE  a.capture_status = 1
            AND l.hostId IS NULL
            AND a.date_added >= \'2018-09-01\'
            LIMIT %d',
            IdentityLinker::TYPE_PAYMENT, $limit
        );
    }

    public static function paymentPaypalPull($limit)
    {
        return sprintf('
            SELECT pot.paypal_order_transaction_id as id, po.order_id, pot.date_added, pot.amount, pot
            .transaction_id, pot.note, o.payment_code
            FROM ' . DB_PREFIX . 'paypal_order_transaction pot
            LEFT JOIN ' . DB_PREFIX . 'paypal_order po ON po.paypal_order_id = pot.paypal_order_id
            LEFT JOIN ' . DB_PREFIX . 'order o ON o.order_id = po.order_id
            LEFT JOIN jtl_connector_link l ON pot.paypal_order_transaction_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_PAYMENT, $limit
        );
    }

    public static function paymentWorldpayPull($limit)
    {
        return sprintf('
            SELECT wot.worldpay_order_transaction_id as id, wo.order_id, wot.date_added, wot.amount, o.payment_code
            FROM ' . DB_PREFIX . 'worldpay_order_transaction wot
            LEFT JOIN ' . DB_PREFIX . 'worldpay_order wo ON wo.worldpay_order_id = wot.worldpay_order_id
            LEFT JOIN ' . DB_PREFIX . 'order o ON o.order_id = wo.order_id
            LEFT JOIN jtl_connector_link l ON wot.worldpay_order_transaction_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_PAYMENT, $limit
        );
    }

    public static function paymentBluepayRedirectPull($limit)
    {
        return sprintf('
            SELECT brot.bluepay_redirect_order_transaction_id as id, bro.order_id, brot.date_added, brot.amount, bro
            .transaction_id, o.payment_code
            FROM ' . DB_PREFIX . 'bluepay_redirect_order_transaction brot
            LEFT JOIN ' . DB_PREFIX . 'bluepay_redirect_order bro ON bro.bluepay_redirect_order_id = brot
            .bluepay_redirect_order_id
            LEFT JOIN ' . DB_PREFIX . 'order o ON o.order_id = bro.order_id
            LEFT JOIN jtl_connector_link l ON brot.bluepay_redirect_order_transaction_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_PAYMENT, $limit
        );
    }

    public static function paymentBluepayHostedPull($limit)
    {
        return sprintf('
            SELECT brot.bluepay_hosted_order_transaction_id as id, bro.order_id, brot.date_added, brot.amount, bro
            .transaction_id, o.payment_code
            FROM ' . DB_PREFIX . 'bluepay_hosted_order_transaction brot
            LEFT JOIN ' . DB_PREFIX . 'bluepay_hosted_order bro ON bro.bluepay_hosted_order_id = brot
            .bluepay_hosted_order_id
            LEFT JOIN ' . DB_PREFIX . 'order o ON o.order_id = bro.order_id
            LEFT JOIN jtl_connector_link l ON brot.bluepay_hosted_order_transaction_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_PAYMENT, $limit
        );
    }

    public static function paymentBluepayHostedCard($orderId)
    {
        return sprintf('
            SELECT brc.*, o.order_id
            FROM ' . DB_PREFIX . 'bluepay_hosted_card brc
            LEFT JOIN ' . DB_PREFIX . 'order o ON o.customer_id = brc.customer_id
            WHERE o.order_id = %d',
            $orderId
        );
    }

    public static function paymentBluepayRedirectCard($orderId)
    {
        return sprintf('
            SELECT brc.*, o.order_id
            FROM ' . DB_PREFIX . 'bluepay_redirect_card brc
            LEFT JOIN ' . DB_PREFIX . 'order o ON o.customer_id = brc.customer_id
            WHERE o.order_id = %d',
            $orderId
        );
    }

    public static function paymentWorldpayCard($orderId)
    {
        return sprintf('SELECT * FROM ' . DB_PREFIX . 'worldpay_card WHERE order_id = %d', $orderId);
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Primary Key Mapping">
    public static function hostId($endpointId, $type)
    {
        return sprintf('
            SELECT hostId
            FROM jtl_connector_link
            WHERE endpointId = %s AND type = %s',
            $endpointId, $type
        );
    }

    public static function endpointId($hostId, $type, $clause)
    {
        return sprintf('
            SELECT endpointId
            FROM jtl_connector_link
            WHERE hostId = %s AND type = %s%s',
            $hostId, $type, $clause
        );
    }

    public static function mappingSave($endpointId, $hostId, $type)
    {
        return sprintf('
            INSERT INTO jtl_connector_link (endpointId, hostId, type)
            VALUES ("%s", %s, %s)',
            $endpointId, $hostId, $type
        );
    }

    public static function mappingClear()
    {
        return 'TRUNCATE jtl_connector_link';
    }

    public static function mappingDelete($where)
    {
        return sprintf('DELETE FROM jtl_connector_link %s', $where);
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Product">
    public static function productInsert()
    {
        return 'INSERT INTO ' . DB_PREFIX . 'product () VALUES ()';
    }

    public static function productPull($limit)
    {
        return sprintf('
            SELECT p.*
            FROM ' . DB_PREFIX . 'product p
            LEFT JOIN jtl_connector_link l ON p.product_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_PRODUCT, $limit
        );
    }

    public static function productI18nPull($productId)
    {
        return sprintf('
            SELECT p.*, l.code
            FROM ' . DB_PREFIX . 'product_description p
            LEFT JOIN ' . DB_PREFIX . 'language l ON p.language_id = l.language_id
            WHERE p.product_id = %d',
            $productId
        );
    }

    public static function productStats()
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'product p
            LEFT JOIN jtl_connector_link l ON p.product_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL',
            IdentityLinker::TYPE_PRODUCT
        );
    }

    public static function productCategoryPull($productId)
    {
        return sprintf('
            SELECT *, CONCAT(product_id, "_", category_id) AS id
            FROM ' . DB_PREFIX . 'product_to_category
            WHERE product_id = %d',
            $productId
        );
    }

    public static function productSpecialPull($productId)
    {
        return sprintf('SELECT * FROM ' . DB_PREFIX . 'product_special WHERE product_id = %d', $productId);
    }

    public static function productAttributePull($productId)
    {
        return sprintf('SELECT * FROM ' . DB_PREFIX . 'product_attribute WHERE product_id = %d and language_id = 3', $productId);
    }

    public static function productAttributeI18nPull($attributeId)
    {
        return sprintf('
            SELECT ad.name, l.code, ad.attribute_id
            FROM ' . DB_PREFIX . 'attribute_description ad
            LEFT JOIN ' . DB_PREFIX . 'language l ON ad.language_id = l.language_id
            WHERE ad.attribute_id = %d',
            $attributeId
        );
    }

    public static function productSpecificPull($productId)
    {
        return sprintf('
            SELECT *, CONCAT(product_id, "_", filter_id) AS id
            FROM ' . DB_PREFIX . 'product_filter
            WHERE product_id = %d',
            $productId
        );
    }

    public static function productSetCover($image, $productId)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'product
            SET image = "%s"
            WHERE product_id = %d',
            $image, $productId
        );
    }

    public static function productAddImage($productId, $image, $sortOrder)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'product_image (product_id, image, sort_order)
            VALUES (%d, "%s", %d)',
            $productId, $image, $sortOrder
        );
    }

    public static function productFileDownloadPull($productId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'product_to_download
            WHERE product_id = %d',
            $productId
        );
    }

    public static function topProductsId($moduleName)
    {
        return sprintf('SELECT module_id FROM ' . DB_PREFIX . 'module WHERE name = "%s"', $moduleName);
    }

    public static function productStockLevelPull($limit)
    {
        return sprintf('
            SELECT p.quantity, p.product_id
            FROM ' . DB_PREFIX . 'product p
            LEFT JOIN jtl_connector_link l ON p.product_id = l.endpointId AND l.type = %d
            LIMIT %d',
            IdentityLinker::TYPE_PRODUCT, $limit
        );
    }

    public static function productStockLevelPush($productId, $stockLevel)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'product SET quantity = %d WHERE product_id = %d',
            $stockLevel, $productId
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Product Price">
    public static function productPriceByProduct($product_id)
    {
        return sprintf('
            SELECT product_id, "" as customer_group_id, CONCAT(product_id, "_default") as id
            FROM ' . DB_PREFIX . 'product
            WHERE product_id = %d',
            $product_id
        );
    }

    public static function productPriceItems($product_id)
    {
        return sprintf('
            SELECT price, 0 as quantity, CONCAT(product_id, "_default") as price_id
            FROM ' . DB_PREFIX . 'product
            WHERE product_id = %d',
            $product_id
        );
    }

    public static function productGroupPricesByProduct($product_id)
    {
        return sprintf('
            SELECT product_id, customer_group_id, product_discount_id as id
            FROM ' . DB_PREFIX . 'product_discount
            WHERE product_id = %d
            GROUP BY product_id, customer_group_id',
            $product_id
        );
    }

    public static function productGroupPriceItems($product_id)
    {
        return sprintf('
            SELECT *, product_discount_id as price_id
            FROM ' . DB_PREFIX . 'product_discount
            WHERE product_id = %d',
            $product_id
        );
    }

    public static function productPrice($productId, $groupId)
    {
        return sprintf('
            SELECT product_discount_id
            FROM ' . DB_PREFIX . 'product_discount
            WHERE product_id = %d AND customer_group_id = %d',
            $productId, $groupId
        );
    }

    public static function productPricePush($productId, $price)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'product SET price = %f WHERE product_id = %d',
            $price, $productId
        );
    }

    public static function productPriceUpdate($id, $quantity, $price)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'product_discount SET quantity = %d price = %f
            WHERE product_dicount_id = %d',
            $quantity, $price, $id
        );
    }

    public static function productPriceAdd($productId, $groupId, $quantity, $price)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'product_discount (product_id, customer_group_id, quantity, price)
            VALUES (%d, %d, %f)',
            $productId, $groupId, $quantity, $price
        );
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Product Variation">
    public static function productVariationPull($productId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'product_option po
            LEFT JOIN ' . DB_PREFIX . 'option o ON po.option_id = o.option_id
            WHERE po.product_id = %d AND o.type NOT IN ("checkbox", "file")',
            $productId
        );
    }

    public static function productVariationI18nPull($productOptionId)
    {
        return sprintf('
            SELECT po.product_option_id, od.name, l.code
            FROM ' . DB_PREFIX . 'option_description od
            LEFT JOIN ' . DB_PREFIX . 'product_option po ON po.option_id = od.option_id
            LEFT JOIN ' . DB_PREFIX . 'language l ON l.language_id = od.language_id
            WHERE po.product_option_id = %d',
            $productOptionId
        );
    }

    public static function productVariationValuePull($productOptionId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'product_option_value
            WHERE product_option_id = %d',
            $productOptionId
        );
    }

    public static function productVariationValueI18nPull($productOptionValueId)
    {
        return sprintf('
            SELECT pov.product_option_value_id, ovd.name, l.code
            FROM ' . DB_PREFIX . 'product_option_value pov
            LEFT JOIN ' . DB_PREFIX . 'option_value_description ovd ON pov.option_value_id = ovd.option_value_id
            LEFT JOIN ' . DB_PREFIX . 'language l ON ovd.language_id = l.language_id
            WHERE pov.product_option_value_id = %d',
            $productOptionValueId
        );
    }

    public static function fileUploadPull($limit)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'product_option po
            LEFT JOIN ' . DB_PREFIX . 'option o ON po.option_id = o.option_id
            LEFT JOIN ' . DB_PREFIX . 'option_description od ON od.option_id = o.option_id
            WHERE o.type = "file"
            LIMIT %d',
            $limit
        );
    }

    public static function fileUploadPush($productId, $optionId, $required)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'product_option (product_id, option_id, required)
            VALUES (%d, %d, %d)',
            $productId, $optionId, $required
        );
    }

    public static function fileUploadDelete($productOptionId)
    {
        return sprintf(
            'DELETE FROM ' . DB_PREFIX . 'product_option WHERE product_option_id = %d',
            $productOptionId
        );
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Specific">
    public static function specificPull($limit)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'filter_group fg
            LEFT JOIN jtl_connector_link l ON fg.filter_group_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL
            LIMIT %d',
            IdentityLinker::TYPE_SPECIFIC, $limit
        );
    }

    public static function specificI18nPull($specificId)
    {
        return sprintf('
            SELECT fgd.*, l.code
            FROM ' . DB_PREFIX . 'filter_group_description fgd
            LEFT JOIN ' . DB_PREFIX . 'language l ON fgd.language_id = l.language_id
            WHERE fgd.filter_group_id = %d',
            $specificId
        );
    }

    public static function specificValuePull($specificId)
    {
        return sprintf('
            SELECT *
            FROM ' . DB_PREFIX . 'filter
            WHERE filter_group_id = %d',
            $specificId
        );
    }

    public static function specificValueI18nPull($specificValueId)
    {
        return sprintf('
            SELECT fd.*, l.code
            FROM ' . DB_PREFIX . 'filter_description fd
            LEFT JOIN ' . DB_PREFIX . 'language l ON fd.language_id = l.language_id
            WHERE fd.filter_id = %d',
            $specificValueId
        );
    }

    public static function specificValueI18nPush($specificId, $specificValueId, $languageId, $name)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'filter_description (filter_id, language_id, filter_group_id, NAME)
            VALUE (%d, %d, %d, "%s")',
            $specificValueId, $languageId, $specificId, $name
        );
    }

    public static function specificValuePush($specificValueId, $sortOrder)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'filter (filter_group_id, sort_order)
            VALUES (%d, %d)',
            $specificValueId, $sortOrder
        );
    }

    public static function specificValueUpdate($specificValueId, $sortOrder)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'filter SET sort_order = %d WHERE filter_group_id = %d',
            $sortOrder, $specificValueId
        );
    }

    public static function specificStats()
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'filter_group fg
            LEFT JOIN jtl_connector_link l ON fg.filter_group_id = l.endpointId AND l.type = %d
            WHERE l.hostId IS NULL',
            IdentityLinker::TYPE_SPECIFIC
        );
    }

    public static function productSpecificPush($categoryId, $specificValueId)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'category_filter (category_id, filter_id)
            VALUES (%d, %d)',
            $categoryId, $specificValueId
        );
    }

    public static function productSpecificFind($categoryId, $specificValueId)
    {
        return sprintf('
            SELECT COUNT(*)
            FROM ' . DB_PREFIX . 'category_filter
            WHERE category_id = %d AND filter_id = %d',
            $categoryId, $specificValueId
        );
    }
    // </editor-fold>
    //// <editor-fold defaultstate="collapsed" desc="Status Change">
    public static function statusChangeByOrder($orderId)
    {
        return sprintf('SELECT count(*) FROM ' . DB_PREFIX . 'order WHERE order_id = %d', $orderId);
    }

    public static function statusChangeAdd($orderId, $statusId, $payment)
    {
        return sprintf('
            INSERT INTO ' . DB_PREFIX . 'order_history (order_id, order_status_id, notify, COMMENT, date_added)
            VALUES (%d, %d, 0, "Payment: %s", NOW())',
            $orderId, $statusId, $payment
        );
    }

    public static function customerOrderStatusUpdate($orderStatusId, $orderId)
    {
        return sprintf('
            UPDATE ' . DB_PREFIX . 'order
            SET order_status_id = %d, date_modified = NOW()
            WHERE order_id = %d',
            $orderStatusId, $orderId
        );
    }

    public static function customerOrderShippingStatusId($orderId)
    {
        return sprintf('
            SELECT oh.order_status_id
            FROM ' . DB_PREFIX . 'order_status os
            LEFT JOIN ' . DB_PREFIX . 'order_history oh ON oh.order_status_id = os.order_status_id
            WHERE oh.order_id = %d
            ORDER BY oh.date_added
            LIMIT 1',
            $orderId
        );
    }
    // </editor-fold>

    //// <editor-fold defaultstate="collapsed" desc="DeliveryNote">
    public static function setTrackingCodes($codes, $orderId)
    {
        return sprintf('
            UPDATE '. DB_PREFIX . 'order
            SET tracking = \'%s\' 
            WHERE order_id = %d',
            $codes,
            $orderId
        );
    }

    // </editor-fold>

    //// <editor-fold defaultstate="collapsed" desc="Tax">
    public static function taxRatePull()
    {
        return 'SELECT * FROM ' . DB_PREFIX . 'tax_rate';
    }

    public static function taxClassId($rate)
    {
        return sprintf('
            SELECT r.tax_class_id
            FROM ' . DB_PREFIX . 'tax_rule r
            LEFT JOIN ' . DB_PREFIX . 'tax_rate tr ON tr.tax_rate_id = r.tax_rate_id
            WHERE tr.rate = %f',
            $rate
        );
    }

    public static function taxClassPull()
    {
        return 'SELECT * FROM ' . DB_PREFIX . 'tax_class';
    }

    public static function taxRateOfOrder($orderId)
    {
        return sprintf('
            SELECT tr.rate
            FROM ' . DB_PREFIX . 'order_total ot
            LEFT JOIN ' . DB_PREFIX . 'tax_rate tr ON tr.name = ot.title
            WHERE ot.code = "tax" AND ot.order_id = %d',
            $orderId
        );
    }

    public static function taxRate($class)
    {
        return sprintf('
            SELECT SUM(tr.rate)
            FROM ' . DB_PREFIX . 'tax_rule r
            LEFT JOIN ' . DB_PREFIX . 'tax_rate tr ON tr.tax_rate_id = r.tax_rate_id
            WHERE r.tax_class_id = %d AND tr.type = "P"',
            $class
        );
    }

    public static function taxZonePull()
    {
        return 'SELECT * FROM ' . DB_PREFIX . 'geo_zone';
    }

    public static function taxZoneCountryPull($geoZoneId)
    {
        return sprintf('
            SELECT c.iso_code_2, ztgz.geo_zone_id
            FROM ' . DB_PREFIX . 'zone_to_geo_zone ztgz
            LEFT JOIN ' . DB_PREFIX . 'country c ON c.country_id = ztgz.country_id
            WHERE ztgz.geo_zone_id = %d',
            $geoZoneId
        );
    }
    // </editor-fold>
}