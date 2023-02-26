<?php declare(strict_types=1);

namespace Bookee\UI\Console\Navigation;

use Bookee\Application\Navigation\ListRoutes\GetRouteQuery;
use Bookee\Application\Navigation\ListRoutes\GetRouteResponse;
use Bookee\Infrastructure\Bus\Query\QueryBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'bookee:navigation:routes:list',
    description: '> Navigation. Lists available routes.',
    aliases: ['b:n:r:list'],
    hidden: false
)]
class ListRoutesCommand extends Command
{
    public function __construct(private QueryBus $queries)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('offset', null, InputOption::VALUE_REQUIRED, 'Offset.', 0)
            ->addOption('limit', null, InputOption::VALUE_REQUIRED, 'Limit.', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<fg=gray;options=bold>{$this->getDescription()}</>\n");

        $offset = intval($input->getOption('offset'));
        $limit = $input->getOption('limit') ? intval($input->getOption('limit')) : null;

        /** @var GetRouteResponse $response */
        $response = $this->queries->ask(new GetRouteQuery($offset, $limit));

        $table = new Table($output);
        $table->setHeaders([
            new TableCell(count($response->routes) . ' available routes', ['colspan' => 3])
        ]);

        $tableRows = [];

        foreach ($response->routes as $route)
        {
            $tableRows[] = ['# ' . $route['number'], new TableCell($route['title'], ['colspan' => 2])];
            $tableRows[] = new TableSeparator();

            foreach ($route['stops'] as $index => $stop)
            {
                $eta     = (new \DateTimeImmutable())->setTimestamp($stop['eta']);
                $etaDiff = (new \DateTimeImmutable())->setTimestamp($stop['eta'] - ($route['stops'][$index-1]['eta'] ?? 0));

                $tableRows[] = [
                    $eta->format('> H:i:s') . ' (+' . $etaDiff->format('i:s') . ')',
                    new TableCell(($index + 1) . '. ' . $stop['title'], ['colspan' => 2])
                ];

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
