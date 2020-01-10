<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;

class ConvertBashGrepCommand extends Command
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
            ->setName('convert:grep')
            ->setDescription(
                'Convert the output of grep -n to JUnit XML.'
            )
            ->addArgument(
                'input',
                InputArgument::OPTIONAL,
                "The output of the grep command to convert"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jUnitReport = $this->converter->convert(
            (string) $input->getArgument('input')
        );

        $output->write($jUnitReport->__toString());

        if ($jUnitReport->hasFailures()) {
            return 1;
        }
    }
}
