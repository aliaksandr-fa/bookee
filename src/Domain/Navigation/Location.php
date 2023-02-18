<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;


/**
 * Class Location
 *
 * @package Bookee\Domain\Navigation
 */
class Location implements \Stringable, \JsonSerializable
{
    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude
    ) {}

    public static function fromString(string $location): Location
    {
        $coordinates = explode(',', $location);

        return new Location(floatval($coordinates[0]), floatval($coordinates[1]));
    }

    public function __toString(): string
    {
        return sprintf("[%s, %s]", $this->latitude, $this->longitude);
    }

    public function jsonSerialize(): mixed
    {
        return [$this->latitude, $this->longitude];
    }
}