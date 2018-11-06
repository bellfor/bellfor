<?php
namespace jtl\Connector\Event\CustomerOrder;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\CustomerOrder;

class CustomerOrderBeforePullEvent extends Event
{
    const EVENT_NAME = 'customerorder.before.pull';

    protected $customerorder;

    public function __construct(CustomerOrder &$customerorder)
    {
        $this->customerorder = $customerorder;
    }

    public function getCustomerOrder()
    {
        return $this->customerorder;
    }
}