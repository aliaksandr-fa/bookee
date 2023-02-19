<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Navigation;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RouteId;
use Bookee\Domain\Navigation\RouteStop;
use Bookee\Domain\Navigation\RouteStopCollection;
use Bookee\Domain\Navigation\Stop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;


/**
 * Class RoutesFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Navigation
 */
class RoutesFixtures extends Fixture implements DependentFixtureInterface
{
    public const ROUTE_101_NUMBER = 101;
    public const ROUTE_101_ALIAS = 'route_101';
    public const ROUTE_101_STOPS_COUNT = 5;

    public const ROUTE_102_NUMBER = 102;
    public const ROUTE_102_ALIAS = 'route_102';
    public const ROUTE_102_STOPS_COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        $this->createRoute(
            $manager,
            self::ROUTE_101_NUMBER,
            self::ROUTE_101_ALIAS,
            self::ROUTE_101_STOPS_COUNT
        );

        $this->createRoute(
            $manager,
            self::ROUTE_102_NUMBER,
            self::ROUTE_102_ALIAS,
            self::ROUTE_102_STOPS_COUNT
        );

        $manager->flush();
    }

    public function createRoute(ObjectManager $manager, int $routeNumber, string $routeAlias, int $numberOfStops): void
    {
        /** @var Stop $firstStop */
        /** @var Stop $lastStop */
        $firstStop = $this->getReference($routeAlias . '_stop_0');
        $lastStop  = $this->getReference($routeAlias . '_stop_' . ($numberOfStops - 1));

        $faker = Factory::create();

        $routeName     = sprintf("%s: %s -> %s", $routeNumber, $firstStop->title(), $lastStop->title());
        $backRouteName = sprintf("%d: %s -> %s", $routeNumber, $lastStop->title(), $firstStop->title());

        $routesStops    = new RouteStopCollection();
        $backRouteStops = new RouteStopCollection();

        $intervals = $this->generateTimeBetweenStops($faker, $numberOfStops);

        for ($i = 0; $i < $numberOfStops; $i++)
        {
            /** @var Stop $stop */
            $stop = $this->getReference($routeAlias . '_stop_' . $i);
            $etaToStop = array_sum(array_slice($intervals, 0, $i));

            $routesStops[] = new RouteStop($stop->id(), $i, $etaToStop);

            $stop = $this->getReference($routeAlias . '_stop_' . ($numberOfStops - $i - 1));
            $etaToStop = array_sum(array_slice($intervals, - $i, $i));

            $backRouteStops[] = new RouteStop($stop->id(), $i, $etaToStop);
        }

        $route = new Route(RouteId::next(), $routeNumber, $routeName, $routesStops);
        $backRoute = new Route(RouteId::next(), $routeNumber, $backRouteName, $backRouteStops);

        $this->setReference($routeAlias, $route);
        $this->setReference($routeAlias . '_back', $backRoute);

        $manager->persist($route);
        $manager->persist($backRoute);
    }

    public function generateTimeBetweenStops(Generator $faker, $numberOfStops): array
    {
        $etas = [];

        for ($i = 0; $i < $numberOfStops - 1; $i++)
        {
            $etas[] = $faker->numberBetween(30, 1000);
        }

        return $etas;
    }

    public function getDependencies(): array
    {
        return [StopsFixtures::class];
    }
}
