<?php declare(strict_types=1);

namespace Bookee\UI\Console\Navigation;

use Bookee\Infrastructure\Bus\Command\CommandBus;
use Bookee\Infrastructure\Bus\Command\Response;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Bookee\Application\Navigation\CreateRoute as CreateRoute;
use Bookee\Application\Navigation\CreateStops as CreateStops;


#[AsCommand(
    name: 'bookee:navigation:routes:create',
    description: '> Navigation. Create new route.',
    aliases: ['b:n:r:create'],
    hidden: false
)]
class CreateRouteCommand extends Command
{
    public function __construct(private readonly CommandBus $commands)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $helper = $this->getHelper('question');

        $question = new Question('Enter route title: ', false);
        $routeName = $helper->ask($input, $output, $question);

        $question = new Question('Enter route number: ', false);
        $routeNumber = intval($helper->ask($input, $output, $question));

        $output->writeln('');

        $index = 0;
        $stops = [];

        while(true)
        {
            $stopData = $this->askForTheNextStop($helper, $input, $output, $index++);

            if (null === $stopData)
            {
                break;
            }

            $stops[] = $stopData;
        }

        /** @var CreateStops\CreateStopsResult $result */
        $result = $this->persistStops($stops);

        $routeStops = [];

        foreach ($result->ids() as $index => $stopId) {
            $routeStops[] = [
                'id' => $stopId,
                'eta' => $stops[$index]['eta']
            ];
        }

        $command = new CreateRoute\CreateRouteCommand($routeName, $routeNumber);
        $command->stops = $routeStops;

        /** @var CreateRoute\CreateRouteResult $result */
        $result = $this->commands->run($command);

        $output->write("Route created. Uuid: {$result->routeId}\n");

        return Command::SUCCESS;
    }

    private function askForTheNextStop(HelperInterface $helper, InputInterface $input, OutputInterface $output, int $index): array|null
    {
        $question = new Question(sprintf("Stop #%s title: ", $index), false);
        $name = $helper->ask($input, $output, $question);

        if (!$name) return null;

        $question = new Question(sprintf("Stop #%s eta: ", $index), false);
        $eta = $helper->ask($input, $output, $question);

        if ($eta === false) return null;

        $question = new Question(sprintf("Stop #%s location: ", $index), false);
        $location = $helper->ask($input, $output, $question);

        if (!$location) return null;

        $location = array_map(
            fn($coordinate) => floatval(trim($coordinate)),
            explode(',', $location)
        );

        return [
            'title' => $name,
            'eta' => intval($eta),
            'location' => [
                'latitude' => $location[0],
                'longitude' => $location[1]
            ]
        ];
    }

    private function persistStops(array $stops): ?Response
    {
        return $this->commands->run(new CreateStops\CreateStopsCommand($stops));
    }
}