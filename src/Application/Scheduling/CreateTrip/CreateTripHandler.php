<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\CreateTrip;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\Bus\BusRepository;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Scheduling\Driver\DriverRepository;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\RouteRepository;
use Bookee\Domain\Scheduling\Service\CreateTrip\CreateTripService;
use Bookee\Infrastructure\Bus\Command\CommandHandler;
use Bookee\Infrastructure\Bus\Command\Response;


/**
 * Class ScheduleTripHandler
 *
 * @package Bookee\Application\Scheduling\ScheduleTrip
 */
class CreateTripHandler implements CommandHandler
{
    public function __construct(
        private RouteRepository $routes,
        private DriverRepository $drivers,
        private BusRepository $buses,
        private readonly CreateTripService $scheduleTripService
    ){}

    public function __invoke(CreateTripCommand $command): ?Response
    {
        $route  = $this->routes->getById(new RouteId($command->routeId));

        $driver = $this->getDriver($command);
        $bus    = $this->chooseBus($command);

        $trip = $this->scheduleTripService->create(
            $command->getDepartureDateTime(),
            $route,
            $driver,
            $bus,
            $command->seats
        );

        return new CreateTripResult($trip->id()->value());
    }

    private function chooseBus(CreateTripCommand $command): ?Bus
    {
        if ($command->busId)
        {
            return $this->buses->findById(new BusId($command->busId));
        }

        if ($command->chooseBusAutomatically && $command->driverId)
        {
            return $this->buses->getDrivableByDriver(new DriverId($command->driverId));
        }

        return null;
    }

    private function getDriver(CreateTripCommand $command): ?Driver
    {
        if ($command->driverId)
        {
            return $this->drivers->findById(new DriverId($command->driverId));
        }

        return null;
    }
}