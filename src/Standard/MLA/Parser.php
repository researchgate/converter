<?php

namespace Geissler\Converter\Standard\MLA;

use ErrorException;
use Geissler\Converter\Interfaces\ParserInterface;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 */
class Parser implements ParserInterface
{
    /**
     * @var Entries
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new Entries();
    }

    public function parse($data)
    {
        $data = (string) $data;

        if ($data === '') {
            return false;
        }

        $rawEntries = explode(PHP_EOL, $data);
        foreach ($rawEntries as $rawEntry) {
            $entry = $this->parseRawEntry($rawEntry);

            $this->entries->setEntry($entry);
        }

        return true;
    }

    private function parseRawEntry(string $rawEntry): Entry
    {
        $entry = new Entry();

        return $entry;
    }

    public function retrieve()
    {
        if ($this->entries->count() === 0) {
            throw new ErrorException('Entries object is not initialized. Call ACS::parse().');
        }

        return $this->entries;
    }
}
