<?php
namespace Geissler\Converter\Model;

use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-10 at 21:58:41.
 */
class PagesTest extends TestCase
{
    /**
     * @var Pages
     */
    protected $object;
    protected $class = '\Geissler\Converter\Model\Pages';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Pages;
    }

    /**
     * @covers Geissler\Converter\Model\Pages::setEnd
     * @covers Geissler\Converter\Model\Pages::getEnd
     */
    public function testSetAndGetEnd()
    {
        $this->assertInstanceOf($this->class, $this->object->setEnd(23));
        $this->assertEquals(23, $this->object->getEnd());
    }

    /**
     * @covers Geissler\Converter\Model\Pages::setRange
     * @covers Geissler\Converter\Model\Pages::getRange
     */
    public function testSetRange()
    {
        $this->assertInstanceOf($this->class, $this->object->setRange('120-200'));
        $this->assertEquals('120-200', $this->object->getRange());
    }

    /**
     * @covers Geissler\Converter\Model\Pages::setStart
     * @covers Geissler\Converter\Model\Pages::getStart
     */
    public function testSetStart()
    {
        $this->assertInstanceOf($this->class, $this->object->setStart('XI'));
        $this->assertEquals('XI', $this->object->getStart());
    }

    /**
     * @covers Geissler\Converter\Model\Pages::setTotal
     * @covers Geissler\Converter\Model\Pages::getTotal
     */
    public function testSetTotal()
    {
        $this->assertInstanceOf($this->class, $this->object->setTotal('450'));
        $this->assertEquals('450', $this->object->getTotal());
    }
}
