<?php

namespace Geissler\Converter\Standard\AMA;

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
    private const META_DATA_REGEX = '#^([0-9]{4})\;([0-9]+)\(([0-9]+)\)\:([0-9]+)\-([0-9]+)$#';

    /**
     * @var Entries
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new Entries();
    }

    /**
     * Transfer the data from a standard into a \Geissler\Converter\Model\Entries object.
     *
     * @param string $data
     * @return boolean
     */
    public function parse($data)
    {
        $data = (string) $data;

        if ($data === '') {
            return false;
        }

        $rawEntries = explode(PHP_EOL, $data);

        foreach ($rawEntries as $rawEntry) {
            try {
                $entry = $this->parseRawEntry($rawEntry);

                $this->entries->setEntry($entry);
            } catch (InvalidArgumentException $e) {
                return false;
            }
        }

        return true;
    }

    private function parseRawEntry(string $rawEntry): Entry
    {
        $entry = new Entry();

        /* Authors */
        $authorString = $this->getNextDotSeparatedPart($rawEntry);
        $authors = array_map('trim', explode(',', $authorString));

        foreach ($authors as $i => $author) {
            list ($familyName, $givenNames) = explode(' ', $author);
            $person = new Person();

            // "et al" -> this citation has more than 6 authors
            if ('et' === $familyName && 'al' === $givenNames) {
                $person->setFamily('et');
                $person->setGiven('al');

                // Fill authors until it has 7 items
                while ($i < 7) {
                    $entry->getAuthor()->offsetSet($i++, $person);
                }

                break;
            }

            $givenNames = str_split($givenNames, 1);

            $person->setFamily($familyName);
            $person->setGiven(implode(' ', $givenNames));

            $entry->getAuthor()->setPerson($person);
        }

        // Remove author part from string
        $rawEntry = trim(substr($rawEntry, strlen($authorString) + 1));

        /* Article Title */
        $titleString = $this->getNextDotSeparatedPart($rawEntry);
        $entry->setTitle($titleString);

        // Remove title part from string
        $rawEntry = trim(substr($rawEntry, strlen($titleString) + 1));

        /* Journal */
        $journalAbbrevTitle = $this->getNextDotSeparatedPart($rawEntry);
        $entry->setJournalShort($journalAbbrevTitle);

        /* Publication Metadata */
        // Remove journal title part from string
        $rawEntry = trim(substr($rawEntry, strlen($journalAbbrevTitle) + 1));

        $meta = $this->getNextDotSeparatedPart($rawEntry);

        if (false === preg_match(self::META_DATA_REGEX, $meta, $matches)) {
            throw new InvalidArgumentException("Could not parse a metadata section {$meta}.");
        }

        list (, $year, $volume, $issue, $pageStart, $pageEnd) = $matches;

        $date = new Date();
        $date->setYear((int) $year);
        $entry->getOriginalDate()->setDate($date);

        $entry->setVolume($volume);
        $entry->setIssue($issue);

        if ($pageStart && $pageEnd) {
            $entry->getPages()->setStart((int) $pageStart);
            $entry->getPages()->setEnd((int) $pageEnd);
        }

        return $entry;
    }

    private function getNextDotSeparatedPart(string $rawString): string
    {
        if (false === preg_match(self::DOT_SEPARATED_PART, $rawString, $matches)) {
            throw new InvalidArgumentException("Could not parse a dot separated part {$rawString}.");
        }

        list (, $part) = $matches;
        return trim($part);
    }

    /**
     * Retrieve the \Geissler\Converter\Model\Entries object containing the parsed data.
     *
     * @return \Geissler\Converter\Model\Entries
     */
    public function retrieve()
    {
        if ($this->entries->count() === 0) {
            throw new ErrorException('Entries object is not initialized. Call AMA::parse().');
        }

        return $this->entries;
    }
}
