<?php
namespace jtl\Connector\Event\CustomerOrder;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\CustomerOrder;

class CustomerOrderAfterDeleteEvent extends Event
{
    const EVENT_NAME = 'customerorder.after.delete';

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