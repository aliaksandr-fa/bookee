<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Scheduling;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Driver\DrivableBuses;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Scheduling\Driver\PhoneNumber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


/**
 * Class DriversFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Scheduling
 */
class DriversFixtures extends Fixture implements DependentFixtureInterface
{
    public const DRIVERS_COUNT = 30;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::DRIVERS_COUNT; $i++)
        {
            $driver = new Driver(
                DriverId::next(),
                $faker->name(),
                new PhoneNumber($faker->phoneNumber()),
                new DrivableBuses(...$this->chooseDrivableBuses())
            );

            $this->setReference('scheduling_driver_' . $i, $driver);

            $manager->persist($driver);
        }

        $manager->flush();
    }

    private function chooseDrivableBuses(): array
    {
        $faker = Factory::create();

        $ids     = [];
        $number  = $faker->numberBetween(1, BusesFixtures::BUSES_COUNT);
        $indexes = $faker->randomElements(range(0, BusesFixtures::BUSES_COUNT - 1), $number);

        for($i = 0; $i < $number; $i++)
        {
            /** @var Bus $bus */
            $bus = $this->getReference('scheduling_bus_' . $indexes[$i], Bus::class);

            $ids[] = $bus->id();
        }

        return $ids;
    }

    public function getDependencies(): array
    {
        return [BusesFixtures::class];
    }
}
