<?php declare(strict_types=1);

namespace Bookee\Tests\Unit\Domain\Booking;

use Bookee\Domain\Booking\NotEnoughSeatsException;
use Bookee\Domain\Booking\Passenger\PassengerId;
use Bookee\Domain\Booking\RouteId;
use Bookee\Domain\Booking\Trip;
use Bookee\Domain\Booking\TripId;
use PHPUnit\Framework\TestCase;


/**
 * Class TripTest
 *
 * @package Bookee\Tests\Unit\Domain\Booking
 */
class TripTest extends TestCase
{

    /**
     * @test
     */
    public function Should_ReduceSeatsAvailable_When_SeatsAreBooked()
    {
        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 10);

        $this->assertEquals(10, $trip->seats());
        $this->assertEquals(10, $trip->seatsAvailable());

        $trip->book(PassengerId::next(), 1, new \DateTimeImmutable());
        $trip->book(PassengerId::next(), 1, new \DateTimeImmutable());

        $this->assertEquals(8, $trip->seatsAvailable());
    }

    /**
     * @test
     */
    public function Should_ThrowException_When_ZeroSeatsBooked()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Cannot book negative or zero seats.");

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 10);

        $trip->book(PassengerId::next(), 0, new \DateTimeImmutable());
    }

    /**
     * @test
     */
    public function Should_ThrowException_When_NegativeSeatsBooked()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Cannot book negative or zero seats.");

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 10);

        $trip->book(PassengerId::next(), -1, new \DateTimeImmutable());
    }

    /**
     * @test
     */
    public function Should_ThrowException_When_AttemptedToOverbook()
    {
        $this->expectException(NotEnoughSeatsException::class);
        $this->expectExceptionMessage("Not enough seats.");

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 10);

        $trip->book(PassengerId::next(), 11, new \DateTimeImmutable());
    }
}