<?php
namespace jtl\Connector\Event\Specific;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\Specific;

class SpecificBeforePullEvent extends Event
{
    const EVENT_NAME = 'specific.before.pull';

    protected $specific;

    public function __construct(Specific &$specific)
    {
        $this->specific = $specific;
    }

    public function getSpecific()
    {
        return $this->specific;
    }
}