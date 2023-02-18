<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class RouteStopCollection
 *
 * @package Bookee\Domain\Navigation
 */
class RouteStopCollection extends ArrayCollection
{
    public function __construct(array $routeStops = [])
    {
        parent::__construct($routeStops);
    }

    public function current() : RouteStop
    {
        return parent::current();
    }

    public function offsetGet($offset) : RouteStop
    {
        return parent::offsetGet($offset);
    }
}