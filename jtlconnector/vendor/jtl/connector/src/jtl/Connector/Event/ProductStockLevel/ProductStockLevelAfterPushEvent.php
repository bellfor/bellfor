<?php
namespace jtl\Connector\Event\ProductStockLevel;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\ProductStockLevel;

class ProductStockLevelAfterPushEvent extends Event
{
    const EVENT_NAME = 'productstocklevel.after.push';

    protected $productstocklevel;

    public function __construct(ProductStockLevel &$productstocklevel)
    {
        $this->productstocklevel = $productstocklevel;
    }

    public function getProductStockLevel()
    {
        return $this->productstocklevel;
    }
}