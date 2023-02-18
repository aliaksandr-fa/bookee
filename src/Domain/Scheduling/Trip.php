<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Driver\DriverId;


/**
 * Class Trip
 *
 * @package Bookee\Domain\Scheduling
 */
class Trip
{
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
        $this->status = TripStatus::DRAFT;
    }

    public function schedule(): void
    {
        if (!$this->status->isDraft())
        {
            //@todo throw exception
        }

        $this->status = TripStatus::SCHEDULED;

        // @todo: domain event: trip scheduled?
    }

    public function cancel(): void
    {
        if (!$this->status->isScheduled())
        {
            //@todo throw exception
        }

        $this->status = TripStatus::CANCELED;

        // @todo: domain event: trip canceled
    }

    public function isDraft(): bool
    {
        return $this->status->isDraft();
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
        // @todo: DomainEvent Driver unassigned
    }

    public function assignBus(?Bus $bus): void
    {
        if ($bus)
        {
            if ($this->seats !== null)
            {
                if ($bus->seats() < $this->seats)
                {
                    //@todo: throw impossible assign bus with a less then pre allocated seats
                    //@todo: or check of less seats was booked
                }
            }

            $this->seats = $bus->seats();
            $this->busId = $bus->id();
        }
        else
        {
            $this->busId = null;
        }
    }

    public function seats(): int
    {
        return $this->seats ?? 0;
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