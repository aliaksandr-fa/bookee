<?php declare(strict_types=1);

namespace Bookee\UI\Console\Scheduling;

use Bookee\Application\Scheduling\ScheduleTrip\ScheduleTripCommand as ScheduleCommand;
use Bookee\Infrastructure\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            ->addArgument('tripId', InputArgument::REQUIRED, 'Trip uuid.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $tripId = $input->getArgument('tripId');

        $command         = new ScheduleCommand();
        $command->tripId = $tripId;

        $this->commands->run($command);

        $output->write("Trip was scheduled.\n");

        return Command::SUCCESS;
    }
}