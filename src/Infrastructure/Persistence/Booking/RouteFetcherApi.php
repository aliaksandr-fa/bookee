<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking;

use Bookee\Application\Booking\ShowSchedule\Route\RouteData;
use Bookee\Application\Booking\ShowSchedule\Route\RouteFetcher;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;


/**
 * Class ScheduleFetcherSql
 *
 * @package Bookee\Infrastructure\Persistence\Booking
 */
class RouteFetcherApi implements RouteFetcher
{
    public function __construct(private readonly HttpClientInterface $navigationClient) {}

    public function findRouteByRouteId(string $routeId): ?RouteData
    {
        $response = $this->navigationClient->request('GET', "routes/$routeId");

        $data = $response->toArray();

        return new RouteData($data['name']);
    }
}