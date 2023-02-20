<?php declare(strict_types=1);

namespace Bookee\UI\Console\Misc;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'bookee:misc:about',
    description: '> Misc. Print about message.',
    aliases: ['b:m:a'],
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