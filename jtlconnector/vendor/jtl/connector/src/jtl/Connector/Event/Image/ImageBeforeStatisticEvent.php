<?php
namespace jtl\Connector\Event\Image;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\Image;

class ImageBeforeStatisticEvent extends Event
{
    const EVENT_NAME = 'image.before.statistic';

    protected $image;

    public function __construct(Image &$image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
}