<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;

/**
 * Provides a class for ConvertNpmAuditCommand.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Command
 */
final class ConvertNpmAuditCommand extends Command {
  public const INPUT_LENGTH_MAXIMUM = 1024;

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

  /**
   * {@inheritDoc}
   *
   * @throws \JsonException
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $inputContent = $this->getContentFromInput($input);

    $jUnitReport = $this->converter->convert($inputContent);
    $output->write($jUnitReport->__toString());
    if ($jUnitReport->hasFailures()) {
      return self::FAILURE;
    }

    return self::SUCCESS;
  }

  /**
   * Gets the content from the input.
   */
  protected function getContentFromInput(InputInterface $input): string {
    if ($input->hasArgument('input')
          && $input->getArgument('input') !== NULL
          && $input->getArgument('input') !== '') {
      return $input->getArgument('input');
    }

    if (0 !== ftell(STDIN)) {
      return (string) self::FAILURE;
    }

    $inputContent = '';
    while (!feof(STDIN)) {
      $inputContent .= fread(STDIN, self::INPUT_LENGTH_MAXIMUM);
    }

    return $inputContent;
  }

}
