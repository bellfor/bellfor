<?php
namespace jtl\Connector\Event\GlobalData;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\GlobalData;

class GlobalDataAfterStatisticEvent extends Event
{
    const EVENT_NAME = 'globaldata.after.statistic';

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