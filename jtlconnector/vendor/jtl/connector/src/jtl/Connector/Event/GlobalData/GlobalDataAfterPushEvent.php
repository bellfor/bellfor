<?php
namespace jtl\Connector\Event\GlobalData;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\GlobalData;

class GlobalDataAfterPushEvent extends Event
{
    const EVENT_NAME = 'globaldata.after.push';

    protected $globaldata;

    public function __construct(GlobalData &$globaldata)
    {
        $this->globaldata = $globaldata;
    }

    public function getGlobalData()
    {
        return $this->globaldata;
    }
}