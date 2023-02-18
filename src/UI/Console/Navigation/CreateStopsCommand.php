<?php declare(strict_types=1);

namespace Bookee\UI\Console\Navigation;

use Bookee\Infrastructure\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Bookee\Application\Navigation\CreateStops as CreateStops;


#[AsCommand(
    name: 'bookee:navigation:stops:create',
    description: '> Navigation. Batch create stops.',
    aliases: ['b:n:s:create'],
    hidden: false
)]
class CreateStopsCommand extends Command
{
    public function __construct(private readonly CommandBus $commands)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $helper = $this->getHelper('question');

        $output->writeln('');

        $stops = [];

        while(true)
        {
            $index = 0;

            $stopData = $this->askForTheNextStop($helper, $input, $output, $index);

            if (null === $stopData)
            {
                break;
            }

            $stops[] = $stopData;
        }

        $this->commands->run(new CreateStops\CreateStopsCommand($stops));

        $output->write("Stops created.\n");

        return Command::SUCCESS;
    }

    private function askForTheNextStop(HelperInterface $helper, InputInterface $input, OutputInterface $output, int $index): array|null
    {
        $question = new Question(sprintf("Stop #%s title: ", $index), false);
        $name = $helper->ask($input, $output, $question);

        if (!$name) return null;

        $question = new Question(sprintf("Stop #%s location: ", $index), false);
        $location = $helper->ask($input, $output, $question);

        if (!$location) return null;

        $location = array_map(
            fn($coordinate) => floatval(trim($coordinate)),
            explode(',', $location)
        );

        return [
            'title' => $name,
            'location' => [
                'latitude' => $location[0],
                'longitude' => $location[1]
            ]
        ];
    }
}