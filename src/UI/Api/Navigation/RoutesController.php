<?php declare(strict_types=1);

namespace Bookee\UI\Api\Navigation;

use Bookee\Application\Navigation\GetRoute\GetRouteQuery;
use Bookee\Application\Navigation\GetRoute\GetRouteResponse;
use Bookee\Infrastructure\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class RoutesController
 *
 * @package Bookee\UI\Api\Booking
 */
class RoutesController extends AbstractController
{
    #[Route(
        '/routes/{routeId}',
        name: 'navigation.routes',
        methods: ['GET']
    )]
    public function index(string $routeId, QueryBus $queries): Response
    {
        /** @var GetRouteResponse $route */
        $route = $queries->ask(new GetRouteQuery($routeId));

        return new JsonResponse($route->jsonSerialize());
    }
}