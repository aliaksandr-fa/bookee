<?php declare(strict_types=1);

namespace Bookee\UI\Console\Booking;

use Bookee\Application\Booking\ShowBookedTrips\BookedTrip;
use Bookee\Application\Booking\ShowBookedTrips\ShowBookedTripsQuery;
use Bookee\Infrastructure\Bus\Query\QueryBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'bookee:booking:trips:booked',
    description: '> Booking. Shows booked trips for customer.',
    aliases: ['b:b:t:booked'],
    hidden: false
)]
class ShowBookedTripsCommand extends Command
{
    public function __construct(private readonly QueryBus $queries)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('passengerId', InputArgument::REQUIRED, 'Passenger id.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $passengerId = $input->getArgument('passengerId');

        $response = $this->queries->ask(
            new ShowBookedTripsQuery($passengerId)
        );

        $table = new Table($output);
        $table->setHeaders(['Departs', 'Passenger', 'Seats', 'Route']);

        $tableRows   = [];

        /** @var BookedTrip $trip */
        foreach ($response->trips as $trip)
        {

            $tableRows[] = [
                $trip->departsAt->format('Y-m-d H:i'),
                $trip->passenger,
                $trip->seats,
                $trip->routeName
            ];

            $tableRows[] = new TableSeparator();
        }

        array_pop($tableRows);

        $table->addRows($tableRows)->render();


        return Command::SUCCESS;
    }
}