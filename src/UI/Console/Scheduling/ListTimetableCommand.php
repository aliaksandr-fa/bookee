<?php declare(strict_types=1);

namespace Bookee\UI\Console\Scheduling;

use Bookee\Application\Scheduling\GetTimetable\GetTimetableQuery;
use Bookee\Application\Scheduling\GetTimetable\GetTimetableResponse;
use Bookee\Domain\Scheduling\Timetable\Time;
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
    name: 'bookee:scheduling:timetables:list',
    description: '> Scheduling. List timetables for route.',
    aliases: ['b:s:t:list'],
    hidden: false
)]
class ListTimetableCommand extends Command
{
    public function __construct(private QueryBus $queries)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('route', InputArgument::REQUIRED, 'Who do you want to greet?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $uuid = $input->getArgument('route');

        /** @var GetTimetableResponse $response */
        $response = $this->queries->ask(new GetTimetableQuery($uuid));


        $table = new Table($output);
        $table->setHeaders([new TableCell($response->route->name())]);

        $tableRows = [];

        foreach ($response->timetables as $timetable)
        {
            $tableRows[] = [$timetable->day()->name];
            $tableRows[] = [''];

            $hash = [];

            foreach ($timetable->departures() as $departure) {
                $hash[$departure->hours()][] = $departure;
            }

            foreach ($hash as $hour => $departures)
            {
                usort($departures, function (Time $a, Time $b) {
                    if ($a->equals($b))
                    {
                        return 0;
                    }

                    return $a->biggerThan($b) ? 1 : -1;
                });
            }

            ksort($hash);

            foreach ($hash as $hour => $departures)
            {
                $formattedDepartures = array_map(function (Time $departure) {
                    return $departure->format(':i');
                }, $departures);

                $departureHour = str_pad($hour . '', 2, '0', STR_PAD_LEFT) . '| ';
                $departuresLine = implode(' ', $formattedDepartures);

                $tableRows[] = ["<fg=yellow;options=bold>$departureHour</> $departuresLine"];

            }

            $tableRows[] = new TableSeparator();
        }

        array_pop($tableRows);

        $table
            ->addRows($tableRows)
            ->render()
        ;

        return Command::SUCCESS;
    }
}