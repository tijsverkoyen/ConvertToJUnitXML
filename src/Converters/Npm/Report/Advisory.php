<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report;

class Advisory
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $package;

    /**
     * @var string
     */
    private $recommendation;

    /**
     * @var string
     */
    private $severity;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $paths = [];

    public function __construct(
        string $title,
        string $package,
        string $recommendation,
        string $severity,
        string $url,
        ?array $paths = null
    ) {
        $this->title = $title;
        $this->package = $package;
        $this->severity = $severity;
        $this->url = $url;
        $this->paths = $paths;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPackage(): string
    {
        return $this->package;
    }

    public function getPaths(): array
    {
        return $this->paths;
    }

    public function getMessage(int $pathIndex): string
    {
        $message = sprintf(
            '[%1$s] %2$s in %3$s, dependency of %4$s.',
            $this->severity,
            $this->title,
            $this->paths[$pathIndex],
            $this->package
        );

        if ($this->recommendation !== null) {
            $message .= ' ' . $this->recommendation;
        }
        $message .= ' More information on: ' . $this->url;

        return $message;
    }

    public static function fromJson(\stdClass $json): Advisory
    {
        $paths = null;

        if (isset($json->findings[0]->paths)) {
            $paths = $json->findings[0]->paths;
        }

        return new Advisory(
            $json->title,
            $json->module_name,
            $json->recommendation,
            $json->severity,
            $json->url,
            $paths
        );
    }
}
