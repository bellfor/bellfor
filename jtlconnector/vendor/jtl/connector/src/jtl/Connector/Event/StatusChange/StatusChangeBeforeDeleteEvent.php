<?php
namespace jtl\Connector\Event\StatusChange;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\StatusChange;

class StatusChangeBeforeDeleteEvent extends Event
{
    const EVENT_NAME = 'statuschange.before.delete';

    protected $statuschange;

    public function __construct(StatusChange &$statuschange)
    {
        $this->statuschange = $statuschange;
    }

    public function getStatusChange()
    {
        return $this->statuschange;
    }
}