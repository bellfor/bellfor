<?php
namespace jtl\Connector\Event\Category;

use \Symfony\Component\EventDispatcher\Event;
use \jtl\Connector\Model\Category;

class CategoryBeforeStatisticEvent extends Event
{
    const EVENT_NAME = 'category.before.statistic';

    protected $category;

    public function __construct(Category &$category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }
}