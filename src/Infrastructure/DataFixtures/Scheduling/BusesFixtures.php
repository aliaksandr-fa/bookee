<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Scheduling;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\Bus\PlateNumber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


/**
 * Class BusesFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Scheduling
 */
class BusesFixtures extends Fixture
{
    public const BUSES_COUNT = 15;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::BUSES_COUNT; $i++)
        {
            $id = BusId::next();
            $bus = new Bus(
                $id,
                new PlateNumber($faker->countryCode . ' ' . $faker->randomNumber(4)),
                $faker->numberBetween(10, 20)
            );

            $manager->persist($bus);
            $this->setReference('scheduling_bus_' . $i, $bus);
            $this->setReference('scheduling_bus_' . $id->value(), $bus);
        }

        $manager->flush();
    }
}
