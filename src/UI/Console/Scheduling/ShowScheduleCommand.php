<?php declare(strict_types=1);

namespace Bookee\UI\Console\Scheduling;

use Bookee\Application\Scheduling\ShowSchedule\ShowScheduleQuery;
use Bookee\Application\Scheduling\ShowSchedule\ShowScheduleResponse;
use Bookee\Infrastructure\Bus\Query\QueryBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'bookee:scheduling:trips:show',
    description: '> Scheduling. Shows schedule for date and route.',
    aliases: ['b:s:t:show'],
    hidden: false
)]
class ShowScheduleCommand extends Command
{
    public function __construct(private readonly QueryBus $queries)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $defaultDate = (new \DateTimeImmutable())->format('Y-m-d');

        $this
            ->addArgument('routeId', InputArgument::REQUIRED, 'Route uuid.')
            ->addArgument('date', InputArgument::OPTIONAL, 'Schedule date.', $defaultDate)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $routeId = $input->getArgument('routeId');
        $date    = $input->getArgument('date');

        $query = new ShowScheduleQuery($routeId, $date);

        /** @var ShowScheduleResponse $response */
        $response = $this->queries->ask($query);

        if (!$response->hasTrips())
        {
            $output->writeln(["No trips found for route {$response->routeId} ({$response->routeName})\n"]);

            return Command::SUCCESS;
        }

        $table = new Table($output);
        $table->setHeaders([new TableCell($response->date->format('Y-m-d') . ' | ' . $response->routeName, ['colspan' => 5])]);

        $tableRows   = [];
        $tableRows[] = ['trip interval', 'duration', 'seats', 'driver', 'bus'];
        $tableRows[] = new TableSeparator();


        foreach ($response->trips as $trip)
        {
            $tableRows[] = [
                $trip['departs_at_time'] . ' -> ' . $trip['arrives_at_time'],
                $trip['duration_formatted'],
                $trip['seats'] ?? '?',
                $trip['driver_name'] ?? '?' . $trip['driver_phone_number'] ?? '?',
                $trip['bus_plate_number'] ?? '?'
            ];

            $tableRows[] = new TableSeparator();
        }

        array_pop($tableRows);

        $table->addRows($tableRows)->render();


        return Command::SUCCESS;
    }
}