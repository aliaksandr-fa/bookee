<?php declare(strict_types=1);

namespace Bookee\UI\Console\Scheduling;

use Bookee\Application\Scheduling\ScheduleTrip\ScheduleTripCommand as ScheduleCommand;
use Bookee\Application\Scheduling\ScheduleTrip\ScheduleTripResult;
use Bookee\Infrastructure\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'bookee:scheduling:trips:schedule',
    description: '> Scheduling. Schedule a trip.',
    aliases: ['b:s:t:schedule'],
    hidden: false
)]
class ScheduleTripCommand extends Command
{

    public function __construct(private CommandBus $commands)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('routeId', InputArgument::REQUIRED, 'Route uuid.')
            ->addArgument('departureDate', InputArgument::REQUIRED, 'Departure date (YYYY-MM-DD).')
            ->addArgument('departureTime', InputArgument::REQUIRED, 'Departure time (HH:MM).')
            ->addArgument('driverId', InputArgument::OPTIONAL, 'Driver uuid.')
            ->addArgument('busId', InputArgument::OPTIONAL, 'Bus uuid.')

            ->addOption('chooseBusAutomatically', null, InputOption::VALUE_NONE, 'Automatically choose bus from available fro this driver.')
            ->addOption('seats', null, InputOption::VALUE_REQUIRED, 'Allocate this number of seats.')
            ->addOption('duration', null, InputOption::VALUE_REQUIRED, 'Set custom trip duration.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $routeId       = $input->getArgument('routeId');
        $departureDate = $input->getArgument('departureDate');
        $departureTime = $input->getArgument('departureTime');
        $driverId      = $input->getArgument('driverId');
        $busId         = $input->getArgument('busId');

        $chooseBusAutomatically = $input->getOption('chooseBusAutomatically');
        $seats                  = $input->getOption('seats');
        $duration               = $input->getOption('duration');

        $command                         = new ScheduleCommand();
        $command->routeId                = $routeId;
        $command->departureDate          = $departureDate;
        $command->departureTime          = $departureTime ? "$departureTime:00" : $departureTime;
        $command->driverId               = $driverId;
        $command->busId                  = $busId;
        $command->chooseBusAutomatically = $chooseBusAutomatically;
        $command->seats                  = $seats ? (int) $seats : null;
        $command->duration               = $duration ? (int) $duration : null;

        /** @var ScheduleTripResult $result */
        $result = $this->commands->run($command);

        $output->write("Trip was scheduled. Uuid: {$result->tripId}\n");

        return Command::SUCCESS;
    }
}