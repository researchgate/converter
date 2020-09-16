<?php

namespace Geissler\Converter\Standard\AMA;

use Geissler\Converter\Model\Date;
use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use Geissler\Converter\Model\Person;
use PHPUnit\Framework\TestCase;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 * @see https://web.archive.org/web/20200207081150/https://www.bcit.ca/files/library/pdf/bcit-ama_citation_guide.pdf
 */
class AMATest extends TestCase
{
    /**
     * @test
     * @covers \Geissler\Converter\Standard\AMA\AMA::parse
     */
    public function parseWithEmptyStringsReturnsFalse(): void
    {
        $ama = new AMA();
        $this->assertFalse($ama->parse(''));
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\AMA\AMA::parse
     */
    public function parseWithSingleCitationBuildsProperEntries(): void
    {
        $ama = new AMA();
        $input = 'Bond AE, Eshah NF, Bani-Khalid M. Nursing practice breakdowns: Good and bad nursing. Medsurg Nursing. 2012;21(1):16-36.';

        // Parse is successful
        $this->assertTrue($ama->parse($input));

        /** @var Entry $entry */
        $entry = $ama->retrieve()->offsetGet(0);

        /**
         * Assert authors are properly parsed
         */

        /** @var Person $author */
        $author = $entry->getAuthor()->offsetGet(0);
        $this->assertEquals('Bond', $author->getFamily());
        $this->assertEquals('A E', $author->getGiven());

        $author = $entry->getAuthor()->offsetGet(1);
        $this->assertEquals('Eshah', $author->getFamily());
        $this->assertEquals('N F', $author->getGiven());

        $author = $entry->getAuthor()->offsetGet(2);
        $this->assertEquals('Bani-Khalid', $author->getFamily());
        $this->assertEquals('M', $author->getGiven());

        /**
         * Assert title is properly parsed
         */

        $this->assertEquals(
            'Nursing practice breakdowns: Good and bad nursing',
            $entry->getTitle(),
        );

        /**
         * Assert metadata is properly parsed
         */
        $this->assertEquals('Medsurg Nursing', $entry->getJournalShort());

        $this->assertEquals(2012, $entry->getOriginalDate()->offsetGet(0)->getYear());

        $this->assertEquals(21, $entry->getVolume());
        $this->assertEquals(1, $entry->getIssue());

        $this->assertEquals(16, $entry->getPages()->getStart());
        $this->assertEquals(36, $entry->getPages()->getEnd());
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\AMA\AMA::parse
     */
    public function parseWithSevenOrMoreAuthors(): void
    {
        $ama = new AMA();
        $input = 'Bond AE, Eshah NF, Bani-Khalid M, et al. Who uses nursing theory? A univariate descriptive analysis of five years’ research articles. Scand J Caring Sci. 2011;25(2):404-409.';

        // Parse is successful
        $this->assertTrue($ama->parse($input));

        /** @var Entry $entry */
        $entry = $ama->retrieve()->offsetGet(0);

        /** @var Person $author */
        $author = $entry->getAuthor()->offsetGet(0);
        $this->assertEquals('Bond', $author->getFamily());
        $this->assertEquals('A E', $author->getGiven());

        $author = $entry->getAuthor()->offsetGet(1);
        $this->assertEquals('Eshah', $author->getFamily());
        $this->assertEquals('N F', $author->getGiven());

        $author = $entry->getAuthor()->offsetGet(2);
        $this->assertEquals('Bani-Khalid', $author->getFamily());
        $this->assertEquals('M', $author->getGiven());

        $this->assertEquals(
            (new Person())->setFamily('et')->setGiven('al'),
            $entry->getAuthor()->offsetGet(3)
        );
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\AMA\AMA::create
     */
    public function createWithLessThanSevenAuthors(): void
    {
        $ama = new AMA();
        $entries = new Entries();
        $entry = new Entry();
        $entries->setEntry($entry);

        $person = new Person();
        $person->setFamily('Silva')->setGiven('Níckolas');
        $entry->getAuthor()->setPerson($person);

        $entry->setTitle('My test publication');
        $entry->setJournalShort('Research Gate Journal');
        $entry->getOriginalDate()->setDate((new Date())->setYear(2020));
        $entry->setVolume(1);
        $entry->setIssue(1);
        $entry->getPages()->setStart(1);
        $entry->getPages()->setEnd(99);

        $expectedOutput = 'Silva N. My test publication. Research Gate Journal. 2020;1(1):1-99.';
        $this->assertEquals($expectedOutput, $ama->create($entries));
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\AMA\AMA::create
     */
    public function createWithMoreThanSevenAuthors(): void
    {
        $ama = new AMA();
        $entries = new Entries();
        $entry = new Entry();
        $entries->setEntry($entry);

        for ($i = 0; $i < 10; ++$i) {
            $person = new Person();
            $person->setFamily('Silva ' . $i)->setGiven('Níckolas');
            $entry->getAuthor()->setPerson($person);
        }

        $entry->setTitle('My test publication');
        $entry->setJournalShort('Research Gate Journal');
        $entry->getOriginalDate()->setDate((new Date())->setYear(2020));
        $entry->setVolume(1);
        $entry->setIssue(1);
        $entry->getPages()->setStart(1);
        $entry->getPages()->setEnd(99);

        $expectedOutput = 'Silva 0N, Silva 1N, Silva 2N, et al. My test publication. Research Gate Journal. 2020;1(1):1-99.';
        $this->assertEquals($expectedOutput, $ama->create($entries));
    }

    /**
     * @test
     * @coversNothing
     */
    public function parseAndCreateAreIdempotent(): void
    {
        $ama = new AMA();
        $input = 'Silva 0N, Silva 1N, Silva 2N, et al. My test publication. Research Gate Journal. 2020;1(1):1-99.';

        $this->assertTrue($ama->parse($input));
        $entries = $ama->retrieve();

        $output = $ama->create($entries);
        $this->assertEquals($input, $output);
    }
}
