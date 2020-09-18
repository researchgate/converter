<?php

namespace Geissler\Converter\Standard\ACS;

use ErrorException;
use Geissler\Converter\Interfaces\ParserInterface;
use Geissler\Converter\Model\Date;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use Geissler\Converter\Model\Person;
use InvalidArgumentException;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 */
class Parser implements ParserInterface
{
    private const DOT_SEPARATED_PART = '#^([\w\s,:;\-_\(\)\?\’]+)\.#';

    // \D{0,3} is here because "-" can have different multi byte representations
    private const PAGE_RANGE_REGEX = '#(\d+)\D+(\d+)\D+(\d+)\D{0,3}?(\d+)?\.$#';

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

        if (false === preg_match(self::DOT_SEPARATED_PART, $rawEntry, $matches)) {
            throw new InvalidArgumentException("Could not parse author list in {$rawEntry}.");
        }

        list (, $rawAuthorList) = $matches;
        $rawAuthorList = trim($rawAuthorList);
        foreach (explode(';', $rawAuthorList) as $rawAuthor) {
            list ($family, $given) = explode(',', $rawAuthor);

            $person = new Person();
            $person->setFamily($family)->setGiven(trim($given));

            $entry->getAuthor()->setPerson($person);
        }

        $rawEntry = substr($rawEntry, strlen($rawAuthorList) + 1);

        if (false === preg_match(self::PAGE_RANGE_REGEX, $rawEntry, $matches)) {
            throw new InvalidArgumentException("Could not parse page range {$rawEntry}.");
        }

        list ($fullMatch, $year, $volume, $from, $to) = $matches;
        $entry->getPages()->setStart((int) $from);
        if ($to) {
            $entry->getPages()->setEnd((int) $to);
        }

        $rawEntry = trim(substr($rawEntry, 0, strlen($rawEntry) - strlen($fullMatch)));

        $entry->getOriginalDate()->setDate((new Date())->setYear((int) $year));
        $entry->setVolume($volume);

        $journalName = trim($rawEntry);

        // This is quite hacky. But the citation format is very ambiguous. Potential solutions to this
        // include using a language grammar or having a lookup table with common CASSI abbreviations (1k+ entries).
        list ($title) = explode('.', $rawEntry);
        if (strlen($title) > 10) {
            $entry->setTitle($title);
            $journalName = trim(substr($rawEntry, strlen($title) + 1));
        }

        $entry->setJournalShort($journalName);

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
