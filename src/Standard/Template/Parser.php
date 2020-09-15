<?php

namespace Geissler\Converter\Standard\Template;

use ErrorException;
use Geissler\Converter\Interfaces\ParserInterface;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use Geissler\Converter\Model\Person;
use Geissler\Converter\Model\Date;

/**
 * TODO: Parser comment.
 *
 * @author Benjamin Geißler <benjamin.geissler@gmail.com>
 * @license MIT
 */
class Parser implements ParserInterface
{
    /**
     * Transfer the data from a standard into a \Geissler\Converter\Model\Entries object.
     *
     * @param string $data
     * @return boolean
     */
    public function parse($data)
    {
        // TODO: Implement parse() method.
        return false;
    }

    /**
     * Retrieve the \Geissler\Converter\Model\Entries object containing the parsed data.
     *
     * @return \Geissler\Converter\Model\Entries
     */
    public function retrieve()
    {
        // TODO: Implement retrieve() method.
        throw new ErrorException('Implement this method.');
    }
}
