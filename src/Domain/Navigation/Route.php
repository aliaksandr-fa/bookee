<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;

use Doctrine\Common\Collections\Collection;


/**
 * Class Route
 *
 * @package Bookee\Domain\Navigation
 */
class Route
{
    public function __construct(
        private RouteId $id,
        private int $number,
        private string $name,
        private RouteStopCollection|Collection $stops = new RouteStopCollection()
    ) {
        // @todo: ensure route has at least 2 stops (start and finish)
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

    public function hasStops(): bool
    {
        return $this->stops()->count() > 0;
    }

    public function attachStop(StopId $stopId, int $eta = 0): void
    {
        $order = $this->stops()->count();

        $this->ensureAddingCorrectEta($eta);

        $this->stops->add(new RouteStop($this, $stopId, $order, $eta));
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