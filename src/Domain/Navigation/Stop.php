<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;


/**
 * Class Stop
 *
 * @package Bookee\Domain\Navigation
 */
class Stop
{
    public function __construct(
        private StopId $id,
        private string $title,
        private Location $location
    ) {}

    public function id(): StopId
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function location(): Location
    {
        return $this->location;
    }
}