<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;


/**
 * Interface StopsRepository
 *
 * @package Bookee\Domain\Navigation
 */
interface StopsRepository
{
    /**
     * @param StopId $id
     * @return Stop
     * @throws StopNotFoundException
     */
    public function get(StopId $id): Stop;

    public function save(Stop $stop): void;
}