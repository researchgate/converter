<?php
namespace Geissler\Converter\Standard\CSL;

use ErrorException;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-05 at 21:23:33.
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
     * @covers Geissler\Converter\Standard\CSL\Parser::parse
     * @covers Geissler\Converter\Standard\CSL\Parser::createPerson
     * @covers Geissler\Converter\Standard\CSL\Parser::createDate
     * @covers Geissler\Converter\Standard\CSL\Parser::retrieve
     * @dataProvider dataProviderParse
     */
    public function testParse($csl, $authors, $dates, $books, $titles)
    {
        $this->assertTrue($this->object->parse($csl));
        $entries    =   $this->object->retrieve();
        $inner  =   0;
        foreach ($entries as $entry) {
            /** @var $entry \Geissler\Converter\Model\Entry */
            $position = 0;
            foreach ($entry->getAuthor() as $author) {
                /** @var $author \Geissler\Converter\Model\Person */
                $this->assertEquals($authors[$inner][$position], $author->getFamily());
                $position++;
            }

            foreach ($entry->getIssued() as $date) {
                /** @var $date \Geissler\Converter\Model\Date */
                $this->assertEquals($dates[$inner], $date->getYear());
            }

            $this->assertEquals($books[$inner], $entry->getType()->getType());
            $this->assertEquals($titles[$inner], $entry->getTitle());

            $inner++;
        }
    }

    public function dataProviderParse()
    {
        return [
            [
                '[
    {
        "author": [
            {
                "family": "Roe",
                "given": "Jane"
            },
            {
                "family": "Doe",
                "given": "John"
            },
            {
                "family": "Smith",
                "given": "John"
            }
        ],
        "issued": {
          "date-parts": [
            [1995]
          ]
        },
        "id": "ITEM-1",
        "type": "book",
        "page-first": "123",
        "page" : "20-45"
    },
    {
        "author": [
            {
                "family": "Roe",
                "given": "Jane"
            },
            {
                "family": "Noakes",
                "given": "Richard"
            },
            {
                "family": "Brown",
                "given": "Bob"
            }
        ],
        "issued": {
          "date-parts": [
            [1995]
          ]
        },
        "id": "ITEM-2",
        "type": "book"
    }
]',
                [
                    ['Roe', 'Doe', 'Smith'],
                    ['Roe', 'Noakes', 'Brown'],
                ],
                [
                    1995, 1995,
                ],
                [
                    'book', 'book',
                ],
                ['', ''],
            ],
            [
                '[
          {
              "id": "ITEM-1",
              "author" : [
                 {
                    "family": "Wallace-Hadrill",
                    "given": "Andrew"
                 }
              ],
              "issued": {
                  "date-parts": [
                      [
                          "2011"
                      ]
                  ]
              },
              "title": "The monumental centre of Herculaneum. In search of the identities of the public buildings",
              "container-title" : "Journal of Roman Archaeology",
              "volume" : "24",
              "page" : "121-160",
              "original-publisher-place" : "Ann Arbor, Mich.",
              "type": "article-journal"
          }
    ]',
                [
                    ['Wallace-Hadrill'],
                ],
                [
                    '2011',
                ],
                [
                    'articleJournal',
                ],
                ['The monumental centre of Herculaneum. In search of the identities of the public buildings'],
            ],
            [
                '[
    {
        "author": [
            {
                "family": "Άγρας",
                "given": "Τέλλος"
            }
        ],
        "translator": [
            {
                "family": "Dimitriadis",
                "given": "Andreas"
            }
        ],
        "editor": [
            {
                "family": "Σαββίδης",
                "given": "Γ. Π."
            }
        ],
        "container-author": [
            {
                "family": "Καρυωτάκης ",
                "given": "Κώστας"
            }
        ],
        "id": "ITEM-1",
        "issued": {
            "date-parts": [
                [
                    "1998",
                    "12",
                    "24"
                ]
            ]
        },
        "title": "Ο Καρυωτάκης και οι Σάτιρες",
         "container-title":"Ποιήματα και πεζά",
        "type": "chapter"
    }
]',
                [
                    ['Άγρας'],
                ],
                ['1998'],
                ['chapter'],
                ['Ο Καρυωτάκης και οι Σάτιρες'],
            ],
        ];
    }

    /**
     * @covers Geissler\Converter\Standard\CSL\Parser::retrieve
     */
    public function testDoNotRetrieve()
    {
        $this->expectException(ErrorException::class);
        $this->assertFalse($this->object->parse(''));
        $this->object->retrieve();
    }
}
