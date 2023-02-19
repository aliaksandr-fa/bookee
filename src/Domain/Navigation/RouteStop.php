<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;


/**
 * Class RouteStop
 *
 * @package Bookee\Domain\Navigation
 */
class RouteStop
{
    private int $id;
    private Route $route;

    public function __construct(
        private StopId $stopId,
        private int $order,
        private ?int $eta = null,
    ) {}

    public function stopId(): StopId
    {
        return $this->stopId;
    }

    public function order(): int
    {
        return $this->order;
    }

    public function eta(): int
    {
        return $this->eta;
    }

    public function attachToRoute(Route $route): RouteStop
    {
        $this->route = $route;

        return $this;
    }
}