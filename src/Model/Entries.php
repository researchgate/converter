<?php

namespace Geissler\Converter\Model;

/**
 * Group of literature entries as "array"-object.
 *
 * @author Benjamin Geißler <benjamin.geissler@gmail.com>
 * @license MIT
 */
class Entries extends Container
{
    public function setEntry(Entry $entry): Container
    {
        return $this->setData($entry);
    }
}
