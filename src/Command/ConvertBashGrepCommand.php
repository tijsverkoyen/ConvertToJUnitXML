<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;

/**
 * Provides a class for ConvertBashGrepCommand.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Command
 */
final class ConvertBashGrepCommand extends Command {

  /**
   * Constructs a new object.
   */
  public function __construct(
    private ConverterInterface $converter
  ) {
    parent::__construct();
  }

  /**
   * {@inheritDoc}
   */
  protected function configure(): void {
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

  /**
   * {@inheritDoc}
   *
   * @throws \JsonException
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $jUnitReport = $this->converter->convert(
      (string) $input->getArgument('input')
    );

    $output->write($jUnitReport->__toString());
    if ($jUnitReport->hasFailures()) {
      return self::FAILURE;
    }

    return self::SUCCESS;
  }

}
