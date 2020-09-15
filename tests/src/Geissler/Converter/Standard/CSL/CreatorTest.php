<?php
namespace Geissler\Converter\Standard\CSL;

use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-10 at 14:10:32.
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
     * @covers Geissler\Converter\Standard\CSL\Creator::create
     * @covers Geissler\Converter\Standard\CSL\Creator::getType
     * @covers Geissler\Converter\Standard\CSL\Creator::createPerson
     * @covers Geissler\Converter\Standard\CSL\Creator::createDate
     * @covers Geissler\Converter\Standard\CSL\Creator::retrieve
     * @dataProvider dataProviderForCreate
     */
    public function testCreate($input, $titles, $types, $authors = false, $issued = false, $issuedFull = false)
    {
        $parser =   new Parser();
        $this->assertTrue($parser->parse($input));
        $this->assertTrue($this->object->create($parser->retrieve()));
        $csl    =   json_decode($this->object->retrieve(), true);
        $count  =   0;

        foreach ($csl as $entry) {
            $this->assertEquals($titles[$count], $entry['title']);
            $this->assertEquals($types[$count], $entry['type']);

            if ($authors !== false) {
                $countAuthors   =   count($authors[$count]);
                for ($i = 0; $i < $countAuthors; $i++) {
                    $this->assertEquals($authors[$count][$i]['family'], $entry['author'][$i]['family']);
                    $this->assertEquals($authors[$count][$i]['given'], $entry['author'][$i]['given']);
                }
            }

            if ($issued !== false
                && isset($issued[$count]) == true) {
                $this->assertEquals($issued[$count]['year'], $entry['issued'][0]['year']);
                $this->assertArrayNotHasKey('day', $entry['issued'][0]);
                $this->assertArrayNotHasKey('month', $entry['issued'][0]);
            }

            if ($issuedFull !== false
                && isset($issuedFull[$count]) == true) {
                $this->assertEquals($issuedFull[$count]['year'], $entry['issued'][0]['year']);
                $this->assertEquals($issuedFull[$count]['day'], $entry['issued'][0]['day']);
                $this->assertEquals($issuedFull[$count]['month'], $entry['issued'][0]['month']);
            }

            $count++;
        }
    }

    public function dataProviderForCreate()
    {
        return array(
            array('[
    {
        "event": "Big Event",
        "id": "ITEM-1",
        "title": "My Anonymous Paper",
        "type": "paper-conference"
    },
    {
        "event": "Other Big Event",
        "id": "ITEM-2",
        "title": "My Anonymous Speech",
        "type": "speech"
    }
]',
                array('My Anonymous Paper', 'My Anonymous Speech'),
                array('paper-conference', 'speech'),
                false
            ),
            array('[
    {
		"id": "ITEM-1",
		"title":"Men of Taste: Gender and Authority in the French Culinary Trades, 1730-1830",
		"author": [
			{
				"family": "Davis",
				"given": "Jennifer J."
			}
		],
		"genre": "Ph.D. diss.",
        "publisher": "Pennsylvania State University, History",
		"issued": {
			"date-parts":[
				[2004]
			]
		},
		"type": "thesis"
	}
]',
                array('Men of Taste: Gender and Authority in the French Culinary Trades, 1730-1830'),
                array('thesis'),
                array(
                    array(
                        array(
                            'family'    =>  'Davis',
                            'given'     =>  'Jennifer J.'
                        )
                    )
                ),
                array(
                    array(
                        'year' => ' 2004'
                    )
                )
            ),
            array('[
    {
        "id": "ITEM-1",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookA",
        "type": "article-newspaper"
    },
    {
        "id": "ITEM-2",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookB",
        "type": "article-journal"
    },
    {
        "id": "ITEM-3",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookC",
        "type": "entry-dictionary"
    },
    {
        "id": "ITEM-4",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookD",
        "type": "entry-encyclopedia"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookE",
        "type": "motion_picture"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookF",
        "type": "musical_score"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookG",
        "type": "post-weblog"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookH",
        "type": "personal_communication"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookI",
        "type": "review-book"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookJ",
        "type": "article-magazine"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookK",
        "type": "entry"
    },
    {
        "id": "ITEM-5",
        "issued": {
            "date-parts": [
                [
                    1998,
                    4,
                    10
                ]
            ]
        },
        "title": "BookL",
        "type": "legal_case"
    }
]',
            array(
                'BookA', 'BookB', 'BookC', 'BookD', 'BookE', 'BookF', 'BookG', 'BookH', 'BookI', 'BookJ', 'BookK',
                'BookL'
            ),
            array(
                'article-newspaper', 'article-journal', 'entry-dictionary', 'entry-encyclopedia', 'motion_picture',
                'musical_score', 'post-weblog', 'personal_communication', 'review-book', 'article-magazine', 'entry',
                'legal_case'
            ),
            false,
            false,
            array(
                array(
                    'year' => 1998,
                    'day'   =>  10,
                    'month' =>  4
                )
            ))
        );
    }

    /**
     * @covers Geissler\Converter\Standard\CSL\Creator::retrieve
     * @covers Geissler\Converter\Standard\CSL\Creator::create
     */
    public function testRetrieve()
    {
        $this->assertFalse($this->object->create(new \Geissler\Converter\Model\Entries()));
        $this->assertFalse($this->object->retrieve());
    }
}
