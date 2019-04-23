<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;

class ConvertSensiolabsSecurityCheckCommand extends Command
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
            ->setName('convert:sensiolabs-security-check')
            ->setDescription(
                'Convert the output of security-checker security:check --format=json to JUnit XML.'
            )
            ->addArgument(
                'input',
                InputArgument::REQUIRED,
                "The JSON to convert"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jUnitReport = $this->converter->convert(
            $input->getArgument('input')
        );

        $output->write($jUnitReport->__toString());

        if (!$jUnitReport->isEmpty()) {
            return 1;
        }
    }
}
