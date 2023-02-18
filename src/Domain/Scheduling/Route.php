<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

/**
 * Class Route
 *
 * @package Bookee\Domain\Scheduling
 */
class Route
{
    public function __construct(
        private RouteId $id,
        private string $name,
        private int $duration
    ) {}

    public function duration(): int
    {
        return $this->duration;
    }

    public function id(): RouteId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}