<?php declare(strict_types=1);

namespace Bookee\UI\Console\Booking;

use Bookee\Infrastructure\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Bookee\Application\Booking\BookTrip\BookTripCommand as BookCommand;


#[AsCommand(
    name: 'bookee:booking:trips:book',
    description: '> Booking. Book a trip for a passenger.',
    aliases: ['b:b:t:book'],
    hidden: false
)]
class BookTripCommand extends Command
{
    public function __construct(private readonly CommandBus $commands)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('tripId', InputArgument::REQUIRED, 'Trip id.')
            ->addArgument('passengerId', InputArgument::REQUIRED, 'Passenger id.')
            ->addArgument('seats', InputArgument::REQUIRED, 'Number of seats to book.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $tripId      = $input->getArgument('tripId');
        $passengerId = $input->getArgument('passengerId');
        $seats       = $input->getArgument('seats');

        $command = new BookCommand($tripId, $passengerId, (int) $seats);

        $this->commands->run($command);

        $output->write("Trip was booked.\n");

        return Command::SUCCESS;
    }

}