<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;

use Bookee\Domain\Shared\EventsTrait;
use Doctrine\Common\Collections\Collection;


/**
 * Class Route
 *
 * @package Bookee\Domain\Navigation
 */
class Route
{
    use EventsTrait;

    public function __construct(
        private RouteId $id,
        private int $number,
        private string $name,
        private RouteStopCollection|Collection $stops = new RouteStopCollection()
    ) {
        $this->ensureRouteStopsValidity();
    }

    public static function create(RouteId $id, int $number, string $name, RouteStopCollection $stops = new RouteStopCollection()): self
    {
        $route = new self($id, $number, $name, $stops);

        $route->recordEvent(
            new RouteCreatedDomainEvent(
                $id->value(),
                $number,
                $name,
                array_map(fn(RouteStop $routeStop) => [$routeStop->stopId(), $routeStop->eta()], $stops->toArray()),
                $route->duration()
            )
        );

        return $route;
    }

    private function ensureRouteStopsValidity(): void
    {
        if ($this->stops()->count() < 2)
        {
            throw new \InvalidArgumentException('Route must have more than one stop.');
        }

        $this->sortStopsByOrder();

        for ($i = 0; $i < $this->stops()->count(); $i++)
        {
            $current = $this->stops()[$i];
            $next    = $this->stops()[$i + 1] ?? null;

            if ($next && $next->eta() <= $current->eta())
            {

                throw new \InvalidArgumentException("Next stop's eta should be more than previous stop's eta.");
            }
        }

        foreach ($this->stops() as $stop)
        {
            $stop->attachToRoute($this);
        }
    }

    private function sortStopsByOrder(): void
    {
        $stops = $this->stops()->getIterator();
        $stops->uasort(fn (RouteStop $a, RouteStop$b) => ($a->order() < $b->order()) ? -1 : 1);
        $this->stops = new RouteStopCollection(array_values($stops->getArrayCopy()));
    }

    public function id(): RouteId
    {
        return $this->id;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function stops(): RouteStopCollection|Collection
    {
        return $this->stops;
    }


    public function attachStop(StopId $stopId, int $eta = 0): void
    {
        $order = $this->stops()->count();

        $this->ensureAddingCorrectEta($eta);

        $this->stops->add((new RouteStop($stopId, $order, $eta))->attachToRoute($this));
    }

    public function hasStops(): bool
    {
        return $this->stops()->count() > 0;
    }

    private function ensureAddingCorrectEta(int $eta): void
    {
        if (!$this->hasStops())
        {
            return;
        }

        $lastStopEta = $this->stops()->last()->eta();

        if ($lastStopEta >= $eta)
        {
            throw new \InvalidArgumentException("Eta for attachable stop should be more than previous stop's eta.");
        }
    }



    public function duration(): ?int
    {
        if ($this->stops()->count() > 0)
        {
            return $this->stops()->last()->eta();
        }

        return null;
    }
}