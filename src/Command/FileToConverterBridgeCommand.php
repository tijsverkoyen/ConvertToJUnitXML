<?php

declare(strict_types=1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Command;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Provides a class for FileToConverterBridgeCommand.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Command;
 */
final class FileToConverterBridgeCommand extends Command {

  /**
   * {@inheritDoc}
   */
  protected function configure(): void {
    $this
      ->setName('file-to-converter')
      ->setDescription(
        'Passes the file content to a converter.'
      )
      ->addArgument(
        'input-file',
        InputArgument::REQUIRED,
        "The path to the file to extract content from"
      )
      ->addArgument(
        'converter-name',
        InputArgument::REQUIRED,
        "The converter to pass the file content to"
      )
      ->addArgument(
        'output-file',
        InputArgument::REQUIRED,
        "The path to the file to save the output of the converter to"
      );
  }

  /**
   * {@inheritDoc}
   *
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   * @throws \Symfony\Component\Console\Exception\ExceptionInterface
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $inputFilePath = $input->getArgument('input-file');
    $converterCommand = $input->getArgument('converter-name');
    $outputFilePath = $input->getArgument('output-file');

    $resultOutput = new BufferedOutput();
    $command = $this->getCommand($converterCommand);
    $fileContent = $this->getFileContent($inputFilePath);
    $command->run(new ArrayInput(['input' => $fileContent]), $resultOutput);
    $this->saveDataToFile($outputFilePath, $resultOutput->fetch());

    $output->writeln('<info>Successfully converted the file content and saved the result to the output file</info>');

    return self::SUCCESS;
  }

  /**
   * Saves data to the file.
   *
   * @throws \RuntimeException
   */
  private function saveDataToFile(string $filename, string $data): void {
    $resultFile = fopen($filename, 'wb');
    if ($resultFile === FALSE) {
      throw new \RuntimeException("Unable to open file '${filename}'!");
    }

    fwrite($resultFile, $data);
    fclose($resultFile);
  }

  /**
   * Gets the file content.
   *
   * @throws \Symfony\Component\Filesystem\Exception\FileNotFoundException
   */
  private function getFileContent(string $filename): string {
    if (!file_exists($filename)) {
      throw new FileNotFoundException("Could not find the file for: ${filename}");
    }

    return (string) file_get_contents($filename);
  }

  /**
   * Gets the command.
   *
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  private function getCommand(string $name): Command {
    $command = $this->getApplication()?->find($name);
    if ($command === NULL) {
      throw new InvalidInputException('Could not fine the requested converter');
    }

    return $command;
  }

}
