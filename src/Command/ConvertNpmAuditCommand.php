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
                InputArgument::OPTIONAL,
                "The JSON to convert"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasArgument('input')
            && $input->getArgument('input') !== null
            && $input->getArgument('input') !== ''
        ) {
            $inputContent = $input->getArgument('input');
        } else if (0 !== ftell(STDIN)) {
            return 1;
        } else {
            $inputContent = '';

            while (!feof(STDIN)) {
                $inputContent .= fread(STDIN, 1024);
            }
        }

        $jUnitReport = $this->converter->convert(
            $inputContent
        );

        $output->write($jUnitReport->__toString());

        if ($jUnitReport->hasFailures()) {
            return 1;
        }
    }
}
