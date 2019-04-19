<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;

class ConvertNpmAuditCommand extends Command
{
    /**
     * @var ConverterInterface
     */
    private $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('convert:npm-audit')
            ->setDescription(
                'Convert the output of npm audit --json to JUnit XML.'
            )
            ->addArgument(
                'input',
                InputArgument::REQUIRED,
                "The JSON to convert"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write(
            $this->converter->convert(
                $input->getArgument('input')
            )
        );
    }
}
