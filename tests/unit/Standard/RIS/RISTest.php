<?php
namespace Geissler\Converter\Standard\RIS;

use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-10 at 18:01:35.
 */
class RISTest extends TestCase
{
    /**
     * @var RIS
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new RIS;
    }

    /**
     * @covers \Geissler\Converter\Standard\RIS\RIS::__construct
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::parse
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::retrieve
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::create
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::setCreator
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::getCreator
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::setParser
     * @covers \Geissler\Converter\Standard\Basic\StandardAbstract::getParser
     * @dataProvider dataProviderParse
     */
    public function testRIS($input, $output)
    {
        $this->assertTrue($this->object->parse($input));
        $this->assertEquals($output, $this->object->create($this->object->retrieve()));
    }

     public function dataProviderParse()
     {
         return [
             ['TY  - JOUR
TI  - Die Grundlage der allgemeinen Relativitätstheorie
AU  - Einstein, Albert
PY  - 1916
SP  - 769
EP  - 822
JO  - Annalen der Physik
VL  - 49
ER  - ',
                 'TY  - JOUR
AU  - Einstein, Albert
PY  - 1916
SP  - 769
EP  - 822
JO  - Annalen der Physik
T1  - Die Grundlage der allgemeinen Relativitätstheorie
VL  - 49
ER  - ',
             ],
         ];
     }
}
