<?php

namespace Geissler\Converter\Model;

/**
 * Group of Person objects as "array" object.
 *
 * @author Benjamin Geißler <benjamin.geissler@gmail.com>
 * @license MIT
 */
class Persons extends Container
{
    public function setPerson(Person $person): Container
    {
        return $this->setData($person);
    }
}
