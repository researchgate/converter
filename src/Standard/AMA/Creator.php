<?php

namespace Geissler\Converter\Standard\AMA;

use Geissler\Converter\Interfaces\CreatorInterface;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use Geissler\Converter\Model\Person;
use Geissler\Converter\Model\Persons;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 */
class Creator implements CreatorInterface
{
    private $entries = [];

    /**
     * Create entries based on the given standard from the \Geissler\Converter\Model\Entries object.
     *
     * @param \Geissler\Converter\Model\Entries $data
     * @return boolean
     */
    public function create(Entries $data)
    {
        /** @var Entry $entry */
        foreach ($data as $entry) {
            $arrayEntry = [
                'authors' => [],
                'title' => $entry->getTitle(),
                'journal' => $entry->getJournalShort(),
                'volume' => $entry->getVolume(),
                'issue' => $entry->getIssue(),
                'year' => $entry->getOriginalDate()->offsetGet(0)->getYear(),
                'page' => "{$entry->getPages()->getStart()}-{$entry->getPages()->getEnd()}",
            ];

            /** @var Person $author */
            foreach ($entry->getAuthor() as $i => $author) {
                if ($i === 3 && $entry->getAuthor()->count() > 6) {
                    $arrayEntry['authors'][] = 'et al';
                    break;
                }

                $familyNames = explode(' ', $author->getFamily());
                $familyName = array_shift($familyNames);

                $letters = array_map(function (string $name) {
                    return strtoupper(substr($name, 0, 1));
                }, array_merge($familyNames, explode(' ', $author->getGiven())));

                $author = $familyName . ' ' . implode('', $letters);

                $arrayEntry['authors'][] = $author;
            }

            $this->entries[] = $arrayEntry;
        }

        return true;
    }

    /**
     * Retrieve the created standard data. Return false if standard could not be created.
     *
     * @return string|boolean
     */
    public function retrieve()
    {
        $entries = [];

        foreach ($this->entries as $entry) {
            $parts = [];
            $author = implode(', ', $entry['authors'] ?? []);
            if ('' !== $author) {
                $parts[] = $author;
            }

            if ('' !== $entry['title']) {
                $parts[] = $entry['title'];
            }

            if ('' !== $entry['journal']) {
                $parts[] = $entry['journal'];
            }

            $meta = '';
            if ('' !== $entry['year']) {
                $meta .= $entry['year'] . ';';
            }

            if ('' !== $entry['volume']) {
                $meta .= $entry['volume'];
            }

            if ('' !== $entry['issue']) {
                $meta .= "({$entry['issue']})";
            }

            if ('-' !== $entry['page']) {
                $meta .= ":{$entry['page']}";
            }

            if ('' !== $meta) {
                $parts[] = $meta;
            }

            $entries[] = implode('. ', $parts) . '.';
        }

        return implode(PHP_EOL, $entries);
    }
}
