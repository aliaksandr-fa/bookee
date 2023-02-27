<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Booking;

use Bookee\Domain\Booking\Passenger\Name;
use Bookee\Domain\Booking\Passenger\Passenger;
use Bookee\Domain\Booking\Passenger\PassengerId;
use Bookee\Domain\Booking\Passenger\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


/**
 * Class PassengersFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Booking
 */
class PassengersFixtures extends Fixture
{
    public const PASSENGERS_COUNT = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::PASSENGERS_COUNT; $i++)
        {
            $id = PassengerId::next();

            $passenger = new Passenger(
                $id,
                new Name($faker->firstName(), $faker->randomElement([null, $faker->lastName()])),
                new Phone($faker->phoneNumber())
            );

            $manager->persist($passenger);

            $this->setReference('booking_passenger_' . $i, $passenger);
            $this->setReference('booking_passenger_' . $id->value(), $passenger);
        }

        $manager->flush();
    }
}
