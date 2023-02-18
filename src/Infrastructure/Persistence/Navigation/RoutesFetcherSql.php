<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Navigation;

use Bookee\Application\Navigation\ListRoutes\RoutesFetcher;
use Doctrine\DBAL\Connection;


/**
 * Class RoutesFetcherSql
 *
 * @package Bookee\Infrastructure\Persistence\Navigation
 */
class RoutesFetcherSql implements RoutesFetcher
{
    public function __construct(private Connection $connection) {}

    public function listRoutes(int $offset = 0, ?int $limit = null): array
    {
        $routesSubquery = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('navigation_routes', 'routes')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
        ;

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'r.id as route_id',
                'r.number as route_number',
                'r.name as route_name',
                'rs.stop_id as stop_id',
                'rs.eta as stop_eta',
                'rs.stop_order as stop_order',
                's.title as stop_title',
                's.location_latitude as stop_latitude',
                's.location_longitude as stop_longitude',
            )
            ->from('('. $routesSubquery->getSQL() . ')', 'r')
            ->leftJoin('r', 'navigation_routes_stops', 'rs', 'r.id = rs.route_id')
            ->leftJoin('r', 'navigation_stops', 's', 'rs.stop_id = s.id')
            ->addOrderBy('rs.route_id', 'asc')
            ->addOrderBy('rs.stop_order', 'asc')
        ;

        $result = $qb->executeQuery()->fetchAllAssociative();
        $routes = [];

        foreach ($result as $item)
        {

            $routes[$item['route_id']]['number'] = $item['route_number'];
            $routes[$item['route_id']]['title']   = $item['route_name'];

            $location = [(double) $item['stop_latitude'], (double) $item['stop_longitude']];

            $routes[$item['route_id']]['stops'][] = [
                'id' => $item['stop_id'],
                'eta' => $item['stop_eta'],
                'title' => $item['stop_title'] . ' [' . implode(', ', $location) . ']',
            ];
        }

        return $routes;
    }
}