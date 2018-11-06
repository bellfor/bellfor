<?php
namespace jtl\Connector\Event\ProductStockLevel;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\ProductStockLevel;

class ProductStockLevelBeforePushEvent extends Event
{
    const EVENT_NAME = 'productstocklevel.before.push';

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