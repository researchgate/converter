<?php
namespace Geissler\Converter\Standard\RIS;

use ErrorException;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use Geissler\Converter\Model\Person;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-10 at 18:01:49.
 */
class ParserTest extends TestCase
{
    /**
     * @var Parser
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Parser;
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Parser::parse
     * @covers Geissler\Converter\Standard\RIS\Parser::getType
     * @covers Geissler\Converter\Standard\RIS\Parser::getDate
     * @covers Geissler\Converter\Standard\RIS\Parser::getPerson
     * @covers Geissler\Converter\Standard\RIS\Parser::retrieve
     * @dataProvider dataProviderForParse
     */
    public function testParse($data)
    {
        $this->assertTrue($this->object->parse($data['input']));
        $this->assertInstanceOf(Entries::class, $this->object->retrieve());
        $entries    =   $this->object->retrieve();

        foreach ($entries as $entry) {
            /** @var $entry Entry */
            $this->assertEquals($data['title'], $entry->getTitle());
            $this->assertEquals($data['type'], $entry->getType()->getType());

            $count  =   0;
            foreach ($entry->getAuthor() as $author) {
                /** @var $author Person */
                $this->assertEquals($data['authors'][$count]['family'], $author->getFamily());
                $this->assertEquals($data['authors'][$count]['given'], $author->getGiven());
                $count++;
            }

            if (isset($data['editors']) == true) {
                $count  =   0;
                foreach ($entry->getEditor() as $editor) {
                    /** @var $editor Person */
                    $this->assertEquals($data['editors'][$count]['family'], $editor->getFamily());
                    $this->assertEquals($data['editors'][$count]['given'], $editor->getGiven());
                    $count++;
                }
            }

            if (isset($data['container']) == true) {
                $this->assertEquals($data['container'], $entry->getContainerTitleShort());
            }

            if (isset($data['containerFull']) == true) {
                $this->assertEquals($data['containerFull'], $entry->getContainerTitle());
            }

            if (isset($data['keyword']) == true) {
                $this->assertEquals($data['keyword'], $entry->getKeyword());
            }

            if (isset($data['year']) == true) {
                $date   =   $entry->getIssued();
                $date   =   $date[0];
                $this->assertEquals($data['year'], $date->getYear());
            }

            if (isset($data['month']) == true) {
                $date   =   $entry->getIssued();
                $date   =   $date[0];
                $this->assertEquals($data['month'], $date->getMonth());
            }
        }
    }

    public function dataProviderForParse()
    {
        return [
            [
                [
                    'input' =>  'TY  - JOUR
TI  - Die Grundlage der allgemeinen Relativitätstheorie
AU  - Einstein, Albert
PY  - 1916/12/24
SP  - 769
EP  - 822
JO  - Annalen der Physik
VL  - 49
ER  - ',
                    'authors'   =>  [
                        [
                            'family'    =>  'Einstein',
                            'given'     =>  'Albert',
                        ],
                    ],
                    'year'      =>  1916,
                    'title'     =>  'Die Grundlage der allgemeinen Relativitätstheorie',
                    'type'      =>  'articleJournal',
                    'container' =>  'Annalen der Physik',
                ],
            ],
            [
                [
                    'input' =>  'TY  - JOUR
AU  - Shannon,Claude E.
PY  - 1948/07//
TI  - A Mathematical Theory of Communication
JO  - Bell System Technical Journal
SP  - 379
EP  - 423
VL  - 27
KW  - First
KW  - Second
ER  - ',
                    'authors'   =>  [
                        [
                            'family'    =>  'Shannon',
                            'given'     =>  'Claude E.',
                        ],
                    ],
                    'year'      =>  1948,
                    'title'     =>  'A Mathematical Theory of Communication',
                    'type'      =>  'articleJournal',
                    'container' =>  'Bell System Technical Journal',
                    'month'     =>  '07',
                    'keyword'   =>  ['First', 'Second'],
                ],
            ],
            [
                [
                    'input' =>  'TY  - JOUR
AU  - Baldwin,S.A.
AU  - Fugaccia,I.
AU  - Brown,D.R.
AU  - Brown,L.V.
AU  - Scheff,S.W.
TI  - Blood-brain barrier breach following cortical contusion in the rat
T2  - Journal of Neurosurgery
PY  - 1996
VL  - 85
IS  - 4
SP  - 476-481
SN  - 0022-3085
AB  - Adult Fisher 344 rats were subjected to a unilateral impact to the dorsal cortex above the hippocampus at 3.5 m/sec with a 2 mm cortical depression. This caused severe cortical damage and neuronal loss in hippocampus subfields CAU, CA3 and hilus.
KW  - cortical contusion
KW  - blood-brain barrier
KW  - horseradish peroxidase
KW  - hippocampus
KW  - rat
DO  - DOI:10xxxxxxxx
ER  -  ',
                    'authors'   =>  [
                        [
                            'family'    =>  'Baldwin',
                            'given'     =>  'S.A.',
                        ],
                        [
                            'family'    =>  'Fugaccia',
                            'given'     =>  'I.',
                        ],
                        [
                            'family'    =>  'Brown',
                            'given'     =>  'D.R.',
                        ],
                        [
                            'family'    =>  'Brown',
                            'given'     =>  'L.V.',
                        ],
                        [
                            'family'    =>  'Scheff',
                            'given'     =>  'S.W.',
                        ],

                    ],
                    'year'      =>  1996,
                    'title'     =>  'Blood-brain barrier breach following cortical contusion in the rat',
                    'type'      =>  'articleJournal',
                    'keyword'   =>  [
                        'cortical', 'contusion', 'blood-brain', 'barrier', 'horseradish', 'peroxidase',
                        'hippocampus', 'rat',
                    ],
                ],
            ],
            [
                [
                    'input' =>  'TY  - CHAP
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
                    'authors'   =>  [
                        [
                            'family'    =>  'Franks',
                            'given'     =>  'L.M.',
                        ],
                    ],
                    'editors'   =>  [
                        [
                            'family'    =>  'Jackson',
                            'given'     =>  'H.',
                        ],
                        [
                            'family'    =>  'Weisl',
                            'given'     =>  'R.',
                        ],
                    ],
                    'year'      =>  1991,
                    'title'     =>  'Preface by an AIDS Victim',
                    'type'      =>  'chapter',
                ],
            ],
            [
                [
                    'input' =>  'TY  - THES
A1  - Rieger, Anna-Katharina
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
                    'title'     =>  'Heiligtümer in Ostia',
                    'type'      =>  'thesis',
                    'authors'   =>  [
                        [
                            'family'    =>  'Rieger',
                            'given'     =>  'Anna-Katharina',
                        ],
                    ],
                    'year'      =>  '2004',
                ],
            ],
        ];
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Parser::parse
     * @covers Geissler\Converter\Standard\RIS\Parser::getType
     * @covers Geissler\Converter\Standard\RIS\Parser::getDate
     * @covers Geissler\Converter\Standard\RIS\Parser::getPerson
     * @covers Geissler\Converter\Standard\RIS\Parser::retrieve
     * @dataProvider dataProviderForMultiple
     */
    public function testParseMultiple($input, array $title, array $type, array $authors, array $keywords)
    {
        $this->assertTrue($this->object->parse($input));
        $this->assertInstanceOf(Entries::class, $this->object->retrieve());
        $entries    =   $this->object->retrieve();
        $position   =   0;

        foreach ($entries as $entry) {
            /** @var $entry Entry */
            $this->assertEquals($title[$position], $entry->getTitle());
            $this->assertEquals($type[$position], $entry->getType()->getType());
            $persons    =   $entry->getAuthor();
            /** @var $author Person */
            $author     =   $persons[0];
            $this->assertEquals($authors[$position], $author->getFamily());
            $this->assertEquals($keywords[$position], $entry->getKeyword());

            $position++;
        }
    }

    public function dataProviderForMultiple()
    {
        return [
            [
                'TY  - BOOK
A1  - Iossif, Panagiotis P., Jr
T1  - More than men, less than gods
T2  - studies on royal cult and imperial worship : proceedings of the international colloquium organized by the Belgian School at Athens (November 1 - 2, 2007)

JO  -
JO  - International colloquium. Belgian School at Athens
ED  -
CY  - Leuven [u.a.]
PB  - Peeters
VL  -
IS  -
A3  -
PY  - 2011
SP  - XVII, 735
KW  -  Kaiser Kaiserzeit Kult NochZuLesen Religion

ER  -

TY  - JOUR
A1  - Kellum, B
T1  - Rez. A. Wallace-Hadrill, Rome\'s Cultural Revolution (Cambridge 2008)
T2  -
    JO  - AJPh
JO  -
    ED  -
    CY  -
    PB  -
    VL  - 132
IS  -
    A3  -
    PY  - 2011
SP  - 330-336
KW  -  Geschichte NochZuLesen Sozial

ER  - ',
                ['More than men, less than gods', 'Rez. A. Wallace-Hadrill, Rome\'s Cultural Revolution (Cambridge 2008)'],
                ['book', 'articleJournal'],
                ['Iossif', 'Kellum'],
                [
                    ['Kaiser', 'Kaiserzeit', 'Kult', 'NochZuLesen', 'Religion'],
                    ['Geschichte', 'NochZuLesen', 'Sozial'],
                ],
            ],
        ];
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Parser::parse
     * @covers Geissler\Converter\Standard\RIS\Parser::getType
     * @dataProvider dataProviderTypes
     */
    public function testTypes($input, array $type)
    {
        $this->assertTrue($this->object->parse($input));
        $entries    =   $this->object->retrieve();
        $position   =   0;
        foreach ($entries as $entry) {
            /** @var $entry Entry */
            $this->assertEquals($type[$position++], $entry->getType()->getType());
        }
    }

    public function dataProviderTypes()
    {
        return [
            [
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
                [
                    'articleJournal', 'abstract', 'motionPicture', 'graphic', 'bill', 'book', 'legalCase', 'chapter',
                    'catalog', 'dataset', 'webpage', 'articleMagazine', 'musicalScore', 'articleNewspaper', 'pamphlet',
                    'personalCommunication', 'report', 'manuscript', 'patent', 'video', 'software', 'map', 'slide',
                    'unknown',
                ],
            ],
        ];
    }

    /**
     * @covers Geissler\Converter\Standard\RIS\Parser::parse
     * @covers Geissler\Converter\Standard\RIS\Parser::retrieve
     */
    public function testRetrieve()
    {
        $this->assertFalse($this->object->parse(''));
        $this->expectException(ErrorException::class);
        $this->object->retrieve();
    }
}
