<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;


/**
 * Interface TripRepositoryInterface
 *
 * @package Bookee\Domain\Scheduling
 */
interface TripRepositoryInterface
{
    public function save(Trip $trip): void;
}