<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Scheduling\Bus\BusAssignedDomainEvent;
use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Shared\EventsTrait;


/**
 * Class Trip
 *
 * @package Bookee\Domain\Scheduling
 */
class Trip
{
    use EventsTrait;

    private TripStatus $status;
    private ?DriverId $driverId = null;
    private ?BusId $busId = null;

    public function __construct(
        private TripId $id,
        private RouteId $routeId,
        private \DateTimeImmutable $departsAt,
        private int $duration,
        private ?int $seats = null
    )
    {
        $this->departsAt = $this->trimSeconds($departsAt);
        $this->status    = TripStatus::DRAFT;
    }

    public function schedule(): void
    {
        $this->ensureTripCanBeScheduled();

        $this->status = TripStatus::SCHEDULED;

        $this->recordEvent(
            new TripScheduledDomainEvent(
                $this->id()->value(),
                $this->routeId->value(),
                $this->departsAt,
                $this->seats
            )
        );
    }

    public function cancel(): void
    {
        $this->ensureTripCanBeCanceled();

        $this->status = TripStatus::CANCELED;

        $this->recordEvent(new TripCanceledDomainEvent($this->id()->value()));
    }

    public function assignDriver(?Driver $driver): void
    {
        if ($driver)
        {
            $this->driverId = $driver->id();

            // @todo: DomainEvent Driver assigned/reassigned

            return;
        }

        $this->driverId = null;
    }

    public function assignBus(?Bus $bus): void
    {
        if ($bus)
        {
            if ($this->seats !== null && $this->isScheduled())
            {
                if ($bus->seats() < $this->seats)
                {
                    throw new NotEnoughSeatsException("Assignable bus has less seats than was already allocated.");
                }
            }

            $this->seats = $bus->seats();
            $this->busId = $bus->id();

            $this->recordEvent(new BusAssignedDomainEvent($this->id()->value(), $bus->id()->value()));

        }
        else
        {
            if ($this->isScheduled())
            {
                throw new TripWithoutBusException("Trip is already scheduled. Unable to unassign bus.");
            }

            $this->seats = null;
            $this->busId = null;
        }
    }

    private function isScheduled(): bool
    {
        return $this->status->isScheduled();
    }

    private function ensureTripCanBeScheduled(): void
    {
        if ($this->isScheduled())
        {
            throw new UnableToScheduleTripException("Trip is already scheduled.");
        }

        if (!$this->hasSeats())
        {
            throw new UnableToScheduleTripException("Cannot schedule a trip without seats.");
        }

        if (!$this->status->isDraft())
        {
            throw new UnableToScheduleTripException("Trip is not in 'draft' status.");
        }
    }

    private function ensureTripCanBeCanceled(): void
    {
        if (!$this->status->isDraft())
        {
            throw new UnableToCancelTripException("Trip can be canceled only in 'draft' status.");
        }
    }

    private function hasSeats(): bool
    {
        return $this->seats !== null && $this->seats > 0;
    }

    public function seats(): ?int
    {
        return $this->seats;
    }

    /**
     * @return TripId
     */
    public function id(): TripId
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function departsAt(): \DateTimeImmutable
    {
        return $this->departsAt;
    }

    /**
     * @return int
     */
    public function duration(): int
    {
        return $this->duration;
    }

    /**
     * @return RouteId
     */
    public function routeId(): RouteId
    {
        return $this->routeId;
    }

    /**
     * @return DriverId|null
     */
    public function driverId(): ?DriverId
    {
        return $this->driverId;
    }

    /**
     * @return BusId|null
     */
    public function busId(): ?BusId
    {
        return $this->busId;
    }

    private function trimSeconds(\DateTimeImmutable $date): \DateTimeImmutable
    {
        return $date->setTimestamp(
            $date->getTimestamp() - $date->getTimestamp() % 60
        );
    }
}