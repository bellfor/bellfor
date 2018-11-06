<?php
namespace jtl\Connector\Event\DeliveryNote;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\DeliveryNote;

class DeliveryNoteBeforeStatisticEvent extends Event
{
    const EVENT_NAME = 'deliverynote.before.statistic';

    protected $deliverynote;

    public function __construct(DeliveryNote &$deliverynote)
    {
        $this->deliverynote = $deliverynote;
    }

    public function getDeliveryNote()
    {
        return $this->deliverynote;
    }
}