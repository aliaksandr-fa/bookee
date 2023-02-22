<?php declare(strict_types=1);

namespace Bookee\Tests\Unit\Domain\Scheduling;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripCanceledDomainEvent;
use Bookee\Domain\Scheduling\TripId;
use Bookee\Domain\Scheduling\TripScheduledDomainEvent;
use Bookee\Domain\Scheduling\TripWithoutBusException;
use Bookee\Domain\Scheduling\UnableToCancelTripException;
use Bookee\Domain\Scheduling\UnableToScheduleTripException;
use PHPUnit\Framework\TestCase;


/**
 * Class TripTest
 *
 * @package Bookee\Tests\Unit\Domain\Scheduling
 */
class TripTest extends TestCase
{
    /**
     * @test
     */
    public function Should_TrimSecondsAtDepartureDate_When_TripCreated()
    {
        $departsAt        = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2023-01-01 23:59:59");
        $departsAtTrimmed = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2023-01-01 23:59:00");

        $trip = new Trip(TripId::next(), RouteId::next(), $departsAt, 0);

        $this->assertEquals($departsAtTrimmed->getTimestamp(), $trip->departsAt()->getTimestamp());
    }

    /**
     * @test
     */
    public function Should_CanBeScheduledAndCanceled_When_TripCreated()
    {
        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);

        $this->assertTrue($trip->canBeScheduled());
        $this->assertTrue($trip->canBeCanceled());
    }

    /**
     * @test
     */
    public function Should_ThrowException_When_CannotBeScheduled()
    {
        $this->expectException(UnableToScheduleTripException::class);
        $this->expectExceptionMessage("Unable to schedule a trip.");

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);
        $trip->schedule();
        $trip->schedule();
    }

    /**
     * @test
     */
    public function Should_RecordScheduledDomainEvent_When_TripWasScheduled()
    {
        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);
        $trip->schedule();

        $this->assertContainsOnlyInstancesOf(TripScheduledDomainEvent::class, $trip->releaseEvents());
    }


    /**
     * @test
     */
    public function Should_ThrowException_When_CannotBeCanceled()
    {
        $this->expectException(UnableToCancelTripException::class);
        $this->expectExceptionMessage("Unable to cancel a trip.");

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);
        $trip->schedule();
        $trip->cancel();
    }

    /**
     * @test
     */
    public function Should_RecordCanceledDomainEvent_When_TripWasScheduled()
    {
        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);
        $trip->cancel();

        $this->assertContainsOnlyInstancesOf(TripCanceledDomainEvent::class, $trip->releaseEvents());
    }

    /**
     * @test
     */
    public function Should_UnassignBus_When_NullBusProvided()
    {
        $bus = $this->createMock(Bus::class);
        $bus
            ->method('id')
            ->willReturn(BusId::next())
        ;

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);
        $trip->assignBus($bus);

        $trip->assignBus(null);

        $this->assertNull($trip->busId());
    }

    /**
     * @test
     */
    public function Should_ThrowException_When_AttemptingToUnassignBusFromScheduledTrip()
    {
        $this->expectException(TripWithoutBusException::class);
        $this->expectExceptionMessage("Trip is already scheduled. Unable to unassign bus.");

        $bus = $this->createMock(Bus::class);
        $bus
            ->method('id')
            ->willReturn(BusId::next())
        ;

        $trip = new Trip(TripId::next(), RouteId::next(), new \DateTimeImmutable(), 0);
        $trip->assignBus($bus);
        $trip->schedule();
        $trip->assignBus(null);
    }

}