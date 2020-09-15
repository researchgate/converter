<?php
namespace Geissler\Converter\Standard\RIS;

use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-10 at 18:01:23.
 */
class CreatorTest extends TestCase
{
    /**
     * @var Creator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Creator;
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Creator::create
     * @covers Geissler\Converter\Standard\RIS\Creator::getPerson
     * @covers Geissler\Converter\Standard\RIS\Creator::getDate
     * @covers Geissler\Converter\Standard\RIS\Creator::getType
     * @covers Geissler\Converter\Standard\RIS\Creator::retrieve
     * @dataProvider dataProviderCreate
     */
    public function testCreate($input, $output)
    {
        $parser =   new Parser();
        $this->assertTrue($parser->parse($input));
        $this->assertTrue($this->object->create($parser->retrieve()));
        $this->assertEquals($output, $this->object->retrieve());
    }

    public function dataProviderCreate()
    {
        return array(
            array(
                'TY  - CHAP
AU  - Franks,L.M.
TI  - Preface by an AIDS Victim
PY  - 1991
VL  - 3
T2  - Cancer, HIV and AIDS
T3  - Cancer Studies Series
A2  - Jackson, H.
A2  - Weisl, R.
SP  - vii- viii
CY  - Berkeley, CA
PB  - Berkeley Press
KW  - HIV
KW  - AIDS
DO  - DOI: 10.xxxxxxxxx
SN  - 0-679-40110-5
ER  - ',
                'TY  - CHAP
A2  - Jackson, H.
A2  - Weisl, R.
AU  - Franks, L.M.
PY  - 1991
SP  - vii- viii
SN  - 0-679-40110-5
PB  - Berkeley Press
CY  - Berkeley, CA
T1  - Preface by an AIDS Victim
T2  - Cancer, HIV and AIDS
VL  - 3
DO  - DOI: 10.xxxxxxxxx
KW  - HIV
KW  - AIDS
ER  - '
            ),
            array(
                'TY  - JOUR
A1  - Kellum, B

ER  -

TY  - ABST
A1  - Kellum, B

ER  -

TY  - ADVS
A1  - Kellum, B

ER  -

TY  - ART
A1  - Kellum, B

ER  -

TY  - BILL
A1  - Kellum, B

ER  -

TY  - SER
A1  - Kellum, B

ER  -

TY  - CASE
A1  - Kellum, B

ER  -

TY  - CHAP
A1  - Kellum, B

ER  -

TY  - CTLG
A1  - Kellum, B

ER  -

TY  - DATA
A1  - Kellum, B

ER  -

TY  - ELEC
A1  - Kellum, B

ER  -

TY  - MGZN
A1  - Kellum, B

ER  -

TY  - SOUND
A1  - Kellum, B

ER  -

TY  - NEWS
A1  - Kellum, B

ER  -

TY  - PAMP
A1  - Kellum, B

ER  -

TY  - PCOMM
A1  - Kellum, B

ER  -

TY  - RPRT
A1  - Kellum, B

ER  -

TY  - UNPB
A1  - Kellum, B

ER  -

TY  - PAT
A1  - Kellum, B

ER  -

TY  - VIDEO
A1  - Kellum, B

ER  -

TY  - COMP
A1  - Kellum, B

ER  -

TY  - MAP
A1  - Kellum, B

ER  -

TY  - SLIDE
A1  - Kellum, B

ER  -

TY  - SLID
A1  - Kellum, B

ER  -',
                'TY  - JOUR
AU  - Kellum, B
ER  - ' . '
TY  - ABST
AU  - Kellum, B
ER  - ' . '
TY  - MPCT
AU  - Kellum, B
ER  - ' . '
TY  - ART
AU  - Kellum, B
ER  - ' . '
TY  - BILL
AU  - Kellum, B
ER  - ' . '
TY  - BOOK
AU  - Kellum, B
ER  - ' . '
TY  - CASE
AU  - Kellum, B
ER  - ' . '
TY  - CHAP
AU  - Kellum, B
ER  - ' . '
TY  - CTLG
AU  - Kellum, B
ER  - ' . '
TY  - DATA
AU  - Kellum, B
ER  - ' . '
TY  - ELEC
AU  - Kellum, B
ER  - ' . '
TY  - MGZN
AU  - Kellum, B
ER  - ' . '
TY  - MUSIC
AU  - Kellum, B
ER  - ' . '
TY  - NEWS
AU  - Kellum, B
ER  - ' . '
TY  - PAMP
AU  - Kellum, B
ER  - ' . '
TY  - PCOMM
AU  - Kellum, B
ER  - ' . '
TY  - RPRT
AU  - Kellum, B
ER  - ' . '
TY  - UNPB
AU  - Kellum, B
ER  - ' . '
TY  - PAT
AU  - Kellum, B
ER  - ' . '
TY  - VIDEO
AU  - Kellum, B
ER  - ' . '
TY  - COMP
AU  - Kellum, B
ER  - ' . '
TY  - MAP
AU  - Kellum, B
ER  - ' . '
TY  - SLIDE
AU  - Kellum, B
ER  - ' . '
TY  - BOOK
AU  - Kellum, B
ER  - '
            ),
            array(
                'TY  - THES
A1  - Rieger, Anna-Katharina, Jr
T1  - Heiligtümer in Ostia
T2  -
JO  -
JO  -
ED  -
CY  - München
PB  - Pfeil
VL  - 8
IS  -
A3  -
PY  - 2004
SP  - 320
KW  -  Ceres Fortuna Gelesen Ostia Religion Spes Venus

ER  - ',
                'TY  - THES
AU  - Rieger, Anna-Katharina, Jr
PY  - 2004
SP  - 320
PB  - Pfeil
CY  - München
T1  - Heiligtümer in Ostia
VL  - 8
KW  - Ceres
KW  - Fortuna
KW  - Gelesen
KW  - Ostia
KW  - Religion
KW  - Spes
KW  - Venus
ER  - '
            ),
            array(
                'TY  - JOUR
A1  - Kockel, Valentin
T1  - Funde und Forschungen in den Vesuvstädten II
T2  -
JO  - AA
JO  -
ED  -
CY  -
PB  -
VL  - 22
IS  -
A3  -
PY  - 1986
SP  - 443
EP  - 569
KW  -  Pompeji Religion

ER  - ',
                'TY  - JOUR
AU  - Kockel, Valentin
PY  - 1986
SP  - 443
EP  - 569
JO  - AA
T1  - Funde und Forschungen in den Vesuvstädten II
VL  - 22
KW  - Pompeji
KW  - Religion
ER  - '
            )
        );
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Creator::create
     * @covers Geissler\Converter\Standard\RIS\Creator::getDate
     */
    public function testGetDate()
    {
        $entry  =   new \Geissler\Converter\Model\Entry();
        $date   =   new \Geissler\Converter\Model\Date();
        $date
            ->setYear(1984)
            ->setMonth(1)
            ->setDay(19)
            ->setSeason('Winter');
        $entry->getIssued()->setDate($date);
        $entry->getPages()->setEnd(123);
        $nextDate   =   new \Geissler\Converter\Model\Date();
        $nextDate->setYear(1984)->setSeason('summer');
        $entry->getAccessed()->setDate($nextDate);
        $entry->getType()->setBook();
        $entries    =   new \Geissler\Converter\Model\Entries();
        $entries->setEntry($entry);

        $noYear =   new \Geissler\Converter\Model\Entry();
        $noYear->getType()->setBook();
        $noYear->setTitle('No Year');
        $noYearDate =   new \Geissler\Converter\Model\Date();
        $noYearDate->setDay(19);
        $noYear->getIssued()->setDate($noYearDate);
        $entries->setEntry($noYear);

        $this->assertTrue($this->object->create($entries));
        $this->assertEquals('TY  - BOOK
PY  - 1984/1/19/Winter
Y2  - 1984///summer
EP  - 123
ER  - ' . '
TY  - BOOK
T1  - No Year
ER  - ', $this->object->retrieve());
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Creator::create
     * @covers Geissler\Converter\Standard\RIS\Creator::retrieve
     */
    public function testRetrieve()
    {
        $this->assertFalse($this->object->create(new \Geissler\Converter\Model\Entries()));
        $this->assertFalse($this->object->retrieve());
    }

    public function testArticleType()
    {
        $entry = new Entry();
        $entry->getType()->setArticle();

        $entries = new Entries();
        $entries->setEntry($entry);;

        $this->assertTrue($this->object->create($entries));
        $this->assertStringStartsWith('TY  - JOUR', $this->object->retrieve());
    }
}
