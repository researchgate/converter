<?php

namespace Geissler\Converter\Standard\ACS;

use Geissler\Converter\Interfaces\CreatorInterface;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use Geissler\Converter\Model\Person;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 */
class Creator implements CreatorInterface
{
    private $entries = [];

    public function create(Entries $data)
    {
        /** @var Entry $entry */
        foreach ($data as $entry) {
            $page = $entry->getPages();
            $arrayEntry = [
                'title' => $entry->getTitle(),
                'authors' => [],
                'journal' => $entry->getJournalShort(),
                'year' => $entry->getOriginalDate()->offsetGet(0)->getYear(),
                'volume' => $entry->getVolume(),
                'pages' => $page->getStart() . ($page->getEnd() ? '-' . $page->getEnd() : ''),
            ];

            /** @var Person $author */
            foreach ($entry->getAuthor() as $author) {
                $arrayEntry['authors'][] = "{$author->getFamily()}, {$author->getGiven()}";
            }

            $this->entries[] = $arrayEntry;
        }

        return true;
    }

    public function retrieve()
    {
        $entries = [];

        foreach ($this->entries as $entry) {
            $parts = [];

            $authors = $entry['authors'];
            $parts[] = implode(count($authors) === 2 ? ' and ' : ', ', $authors);

            if ($entry['title']) {
                $parts[] = $entry['title'];
            }

            if ($entry['journal']) {
                $parts[] = $entry['journal'];
            }

            $parts = [implode('. ', $parts)];

            $meta = [];
            if ($entry['year']) {
                $meta[] = $entry['year'];
            }
            if ($entry['volume']) {
                $meta[] = $entry['volume'];
            }
            if ($entry['pages']) {
                $meta[] = $entry['pages'];
            }

            $parts[] = implode(', ', $meta);

            $entries[] = implode(' ', $parts) . '.';
        }

        return implode(PHP_EOL, $entries);
    }
}
