<?php

namespace Geissler\Converter\Standard\MLA;

use Geissler\Converter\Interfaces\CreatorInterface;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;

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
        }

        return true;
    }

    public function retrieve()
    {
        $entries = [];

        foreach ($this->entries as $entry) {
        }

        return implode(PHP_EOL, $entries);
    }
}
