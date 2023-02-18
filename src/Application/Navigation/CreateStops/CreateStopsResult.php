<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateStops;

use Bookee\Infrastructure\Bus\Command\Response;


/**
 * Class CreateStopsResult
 *
 * @package Bookee\Application\Navigation\CreateStops
 */
class CreateStopsResult implements Response
{
    public function __construct(private array $ids = []) {}

    public function addId(string $id)
    {
        $this->ids[] = $id;
    }

    /**
     * @return string[]|array
     */
    public function ids(): array
    {
        return $this->ids;
    }
}