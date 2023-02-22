<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Navigation;

use Bookee\Domain\Navigation\Location;
use Bookee\Domain\Navigation\Stop;
use Bookee\Domain\Navigation\StopId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


/**
 * Class StopsFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Navigation
 */
class StopsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createRouteStops($manager, RoutesFixtures::ROUTE_101_ALIAS, RoutesFixtures::ROUTE_101_STOPS_COUNT);
        $this->createRouteStops($manager, RoutesFixtures::ROUTE_102_ALIAS, RoutesFixtures::ROUTE_102_STOPS_COUNT);

        $manager->flush();
    }

    public function createRouteStops(ObjectManager $manager, string $routeAlias, int $numberOfStops): void
    {
        $faker = Factory::create();

        $baseLatitude  = $faker->latitude();
        $baseLongitude = $faker->longitude();

        for ($i = 0; $i < $numberOfStops; $i++)
        {
            $stop = new Stop(
                StopId::next(),
                $faker->name(),
                new Location($baseLatitude += 0.01, $baseLongitude += 0.01)
            );

            $manager->persist($stop);
            $this->addReference($routeAlias . '_stop_' . $i, $stop);
        }
    }
}
