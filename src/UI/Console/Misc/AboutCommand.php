<?php declare(strict_types=1);

namespace Bookee\UI\Console\Misc;

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
    name: 'bookee:about',
    description: '> Misc. About.',
    aliases: ['b:n:r:create'],
    hidden: false
)]
class AboutCommand extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("\n<fg=yellow;options=bold>
 _____  _____  _____  _____  _____  _____ 
| __  ||     ||     ||  |  ||   __||   __|
| __ -||  |  ||  |  ||    -||   __||   __|
|_____||_____||_____||__|__||_____||_____|                                     
        </>\n");

        return Command::SUCCESS;
    }
}