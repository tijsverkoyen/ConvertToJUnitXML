<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertFromNPMAuditCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('convert:from-npm-audit-json')
            ->setDescription(
                'Convert the output of npm audit --json to JUnit XML.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        throw new \RuntimeException("Not implemented yet.");
    }
}
