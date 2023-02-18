<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;


/**
 * Interface RoutesRepository
 *
 * @package Bookee\Domain\Navigation
 */
interface RoutesRepository
{
    /**
     * @return Route[]
     * @throws RouteNotFoundException
     */
    public function all(): array;

    public function save(Route $route): void;
}