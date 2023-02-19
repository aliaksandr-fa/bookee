<?php declare(strict_types=1);

namespace Bookee\Tests\Unit\Domain\Navigation;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RouteId;
use Bookee\Domain\Navigation\RouteStop;
use Bookee\Domain\Navigation\RouteStopCollection;
use Bookee\Domain\Navigation\StopId;
use PHPUnit\Framework\TestCase;


/**
 * Class RouteTest
 *
 * @package Bookee\Tests\Unit\Domain\Navigation
 */
class RouteTest extends TestCase
{
    /**
     * @test
     * @dataProvider getInvalidCountRouteStopCollectionProvider
     */
    public function Should_ThrowException_When_RouteStopCollectionHasLessThan2Stops(RouteStopCollection $stops)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Route must have more than one stop.');

        new Route(RouteId::next(), 101, 'TEST_ROUTE', $stops);
    }

    /**
     * @test
     * @dataProvider getInvalidEtaOrderRouteStopCollectionProvider
     */
    public function Should_ThrowException_When_RouteStopCollectionHasInvalidEtaOrder(RouteStopCollection $stops)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Next stop's eta should be more than previous stop's eta.");

        new Route(RouteId::next(), 101, 'TEST_ROUTE', $stops);
    }

    public function getInvalidCountRouteStopCollectionProvider(): array
    {
        return [
            [new RouteStopCollection([])],
            [new RouteStopCollection([
                new RouteStop(StopId::next(), 0, 0)
            ])],
        ];
    }

    public function getInvalidEtaOrderRouteStopCollectionProvider(): array
    {
        return [
            [new RouteStopCollection([
                new RouteStop(StopId::next(), 0, 0),
                new RouteStop(StopId::next(), 0, 0)
            ])],
            [new RouteStopCollection([
                new RouteStop(StopId::next(), 0, 100),
                new RouteStop(StopId::next(), 1, 0)
            ])],
            [new RouteStopCollection([
                new RouteStop(StopId::next(), 1, 0),
                new RouteStop(StopId::next(), 0, 100)
            ])],
        ];
    }
}