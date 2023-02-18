<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateStops;

use Bookee\Domain\Navigation\Location;
use Bookee\Domain\Navigation\Stop;
use Bookee\Domain\Navigation\StopId;
use Bookee\Domain\Navigation\StopsRepository;
use Bookee\Infrastructure\Bus\Command\CommandHandler;


/**
 * Class CreateStopsHandler
 *
 * @package Bookee\Application\Navigation\CreateStops
 */
class CreateStopsHandler implements CommandHandler
{
    public function __construct(private readonly StopsRepository $stopsRepository) {}

    public function __invoke(CreateStopsCommand $command)
    {
        $result = new CreateStopsResult();

        foreach ($command->stops as $data) {
            $stopId = StopId::next();

            $this->stopsRepository->save(
                new Stop(
                    $stopId,
                    $data['title'],
                    new Location(
                        $data['location']['latitude'],
                        $data['location']['longitude']
                    )
                )
            );

            $result->addId($stopId->value());
        }

        return $result;
    }
}