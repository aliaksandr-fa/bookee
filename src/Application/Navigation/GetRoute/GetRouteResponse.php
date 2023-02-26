<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\GetRoute;

use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class GetRouteResponse
 *
 * @package Bookee\Application\Navigation\GetRoute
 */
class GetRouteResponse implements Response, \JsonSerializable
{
    public function __construct(
        public string $id,
        public int $number,
        public string $name,
        public int $duration
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'duration' => $this->duration
        ];
    }
}