<?php
namespace jtl\Connector\Event\ProductPrice;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\ProductPrice;

class ProductPriceAfterStatisticEvent extends Event
{
    const EVENT_NAME = 'productprice.after.statistic';

    protected $productprice;

    public function __construct(ProductPrice &$productprice)
    {
        $this->productprice = $productprice;
    }

    public function getProductPrice()
    {
        return $this->productprice;
    }
}