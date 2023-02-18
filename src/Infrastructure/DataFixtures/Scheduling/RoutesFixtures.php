<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Scheduling;

use Bookee\Domain\Navigation\Route as NavigationRoute;
use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\RouteId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Bookee\Infrastructure\DataFixtures\Navigation\RoutesFixtures as NavigationRoutesFixtures;


/**
 * Class RoutesFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Scheduling
 */
class RoutesFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $this->loadRouteFromNavigation($manager, NavigationRoutesFixtures::ROUTE_101_ALIAS);
        $this->loadRouteFromNavigation($manager, NavigationRoutesFixtures::ROUTE_101_ALIAS . '_back');

        $this->loadRouteFromNavigation($manager, NavigationRoutesFixtures::ROUTE_102_ALIAS);
        $this->loadRouteFromNavigation($manager, NavigationRoutesFixtures::ROUTE_102_ALIAS . '_back');

        $manager->flush();
    }

    public function loadRouteFromNavigation(ObjectManager $manager, string $routeAlias): void
    {
        /** @var NavigationRoute $navigationRoute */
        $navigationRoute = $this->getReference($routeAlias, NavigationRoute::class);


        $route = new Route(
            new RouteId($navigationRoute->id()->value()),
            $navigationRoute->name(),
            $navigationRoute->duration()
        );

        $this->setReference('scheduling_' . $routeAlias, $route);

        $manager->persist($route);
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
        return [NavigationRoutesFixtures::class];
    }
}
