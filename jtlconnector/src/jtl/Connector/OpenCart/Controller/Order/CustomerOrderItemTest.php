<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller\Order;

use jtl\Connector\Model\CustomerOrderItem as CustomerOrderItemModel;
use jtl\Connector\Model\CustomerOrderItem as COI;
use jtl\Connector\Model\Identity;
use jtl\Connector\OpenCart\Controller\BaseController;
use jtl\Connector\OpenCart\Exceptions\MethodNotAllowedException;
use jtl\Connector\OpenCart\Mapper\Order\OrderItemDiscountMapper;
use jtl\Connector\OpenCart\Mapper\Order\OrderItemProductMapper;
use jtl\Connector\OpenCart\Mapper\Order\OrderItemShippingMapper;
use jtl\Connector\OpenCart\Utility\Constants;
use jtl\Connector\OpenCart\Utility\SQLs;

class CustomerOrderItemTest extends BaseController
{
    private $tax;
    private $orderId;
    private $productMapper;
    private $shippingMapper;
    private $discountMapper;

    private $methods = [
        'customerOrderProducts' => COI::TYPE_PRODUCT,
        'customerOrderShippings' => COI::TYPE_SHIPPING,
      //  'customerOrderDiscounts' => COI::TYPE_DISCOUNT
    ];

    public function __construct()
    {
        parent::__construct();
        $this->productMapper = new OrderItemProductMapper();
        $this->shippingMapper = new OrderItemShippingMapper();
        $this->discountMapper = new OrderItemDiscountMapper();
    }

    public function pullData(array $data, $model, $limit = null)
    {
        $return = [];
        $orderItemId = 1;
        $currency_value = doubleval($data['currency_value']);
        $this->orderId = $data['order_id'];
        $this->tax = doubleval($this->getTax($this->orderId));
        $taxes = $this->database->query(SQLs::customerOrderProductsTax($this->orderId));

        $product_prices = array();
	    $sum_product_prices = 0.0;

        foreach ($this->methods as $method => $type) {
            $sqlMethod = Constants::UTILITY_NAMESPACE . 'SQLs::' . $method;
            $query = call_user_func($sqlMethod, $this->orderId);
            $items = $this->database->query($query);

            foreach ($items as $index => $item) {
                //TODO: eventuell ordentlich einbauen
                $item['name'] = str_ireplace("&quot;", '"', $item['name']);
                $vat = $this->tax;
                if($vat != 0)
                {
                    if($method == 'customerOrderShippings')
                    {
                        $vat = 7.0;
                        //$item['value'] =  $item['value'] * (1/((100+$this->tax) / 100));
                    }

                    else
                        foreach($taxes as $i => $tax)
                        {
                            if($item['product_id'] == $tax['product_id'])
                            {
                                $vat = $tax['rate'];
                            }
                        }
                }

                if(!isset($product_prices[(string)$vat]))
	                $product_prices[(string)$vat] = 0.0;

	            $product_prices[(string)$vat] += $item['quantity'] * $item['price'];
	            $sum_product_prices += $item['quantity'] * $item['price'];

                $return[] = $this->mapItem($type, $item, $orderItemId++, $vat, $currency_value);
            }
        }

        $product_price_rel = array();

        foreach($product_prices as $temp_vat => $value)
        	$product_price_rel[$temp_vat] = $value / $sum_product_prices;

        //discounts
        $result = $this->database->query(SQLs::customerOrderDiscountsOwn($data['order_id']));
        if(!empty($result))
            foreach($result as $itemDiscount)
            {
                $item = new CustomerOrderItemModel();
                $item->setName($itemDiscount['title']);
                $price = (double) $itemDiscount['value'];

                if($itemDiscount['code'] == 'coupon' || $itemDiscount['code'] == 'reorder_discount' || $itemDiscount['code'] == 'total_customer_group_discount')
                {
                	$add_tax = 0.0;
	                //$price = $price * ((100+$this->tax) / 100);
	                foreach($product_price_rel as $temp_vat => $rel)
	                {
	                	$add_tax += $price * $rel * ($temp_vat/ 100);
	                }

	                $price = $price + $add_tax;
                	//$price = $price * ((100+$this->tax) / 100);
                }

                if($itemDiscount['code'] == 'reorder_discount' && $price > 0)
                    $price = (-1) * $price;

                $price = $currency_value * $price;
                $item->setPrice($price);
                $item->setQuantity(1);
                $item->setId(new Identity($this->orderId . '_' . $orderItemId++));
                $return[] = $item;
            }

        return $return;
    }

    private function mapItem($type, $item, $id, $vat, $currency_value)
    {
        $item['order_item_id'] = $this->orderId . '_' . $id;
        $result = $this->{$type . 'Mapper'}->toHost($item);
        if ($result instanceof CustomerOrderItemModel) {
            $result->setId(new Identity($this->orderId . '_' . $id));
            $result->setVat((double) $vat);
            $result->setPrice($currency_value * $result->getPrice());
        }
        return $result;
    }

    protected function pullQuery(array $data, $limit = null)
    {
        throw new MethodNotAllowedException("Use the specific pull methods.");
    }

    private function getTax($orderId)
    {
        return $this->database->queryOne(SQLs::taxRateOfOrder($orderId));
    }
}