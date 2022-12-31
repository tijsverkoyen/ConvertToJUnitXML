<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;

/**
 * Provides a class for ConvertSensiolabsSecurityCheckCommand.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Command
 */
final class ConvertSensiolabsSecurityCheckCommand extends Command {

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

  /**
   * {@inheritDoc}
   *
   * @throws \JsonException
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $jUnitReport = $this->converter->convert(
      $input->getArgument('input')
    );

    $output->write($jUnitReport->__toString());

    if ($jUnitReport->hasFailures()) {
      return self::FAILURE;
    }

    return self::SUCCESS;
  }

}
