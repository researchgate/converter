<?php

namespace Geissler\Converter\Standard\ACS;

use Geissler\Converter\Model\Entries;
use Geissler\Converter\Model\Entry;
use PHPUnit\Framework\TestCase;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 * @see https://web.archive.org/web/20170527202056/https://pubs.acs.org/doi/pdf/10.1021/bk-2006-STYG.ch014 (page 4)
 */
class ACSTest extends TestCase
{
    /**
     * @test
     * @covers \Geissler\Converter\Standard\ACS\ACS::parse
     */
    public function parseWithEmptyStringsReturnsFalse(): void
    {
        $acs = new ACS();
        $this->assertFalse($acs->parse(''));
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\ACS\ACS::parse
     */
    public function parseUnderstandsJournalArticleWithTitle(): void
    {
        $acs = new ACS();
        $input = 'Klingler, J. Influence of Pretreatment on Sodium Powder. Chem. Mater. 2005, 17, 2755-2768.';

        $this->assertTrue($acs->parse($input));
        /** @var Entry $entry */
        $entry = $acs->retrieve()->offsetGet(0);

        $this->assertEquals('Klingler', $entry->getAuthor()->offsetGet(0)->getFamily());
        $this->assertEquals('J', $entry->getAuthor()->offsetGet(0)->getGiven());

        $this->assertEquals(2755, $entry->getPages()->getStart());
        $this->assertEquals(2768, $entry->getPages()->getEnd());

        $this->assertEquals(2005, $entry->getOriginalDate()->offsetGet(0)->getYear());
        $this->assertEquals(17, $entry->getVolume());

        $this->assertEquals('Chem. Mater.', $entry->getJournalShort());
        $this->assertEquals('Influence of Pretreatment on Sodium Powder', $entry->getTitle());
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\ACS\ACS::parse
     */
    public function parseUnderstandsJournalArticleWithoutTitle(): void
    {
        $acs = new ACS();
        $input = 'Klingler, J. Chem. Mater. 2005, 17, 2755-2768.';

        $this->assertTrue($acs->parse($input));
        /** @var Entry $entry */
        $entry = $acs->retrieve()->offsetGet(0);

        $this->assertEquals('Klingler', $entry->getAuthor()->offsetGet(0)->getFamily());
        $this->assertEquals('J', $entry->getAuthor()->offsetGet(0)->getGiven());

        $this->assertEquals(2755, $entry->getPages()->getStart());
        $this->assertEquals(2768, $entry->getPages()->getEnd());

        $this->assertEquals(2005, $entry->getOriginalDate()->offsetGet(0)->getYear());
        $this->assertEquals(17, $entry->getVolume());

        $this->assertEquals('Chem. Mater.', $entry->getJournalShort());
        $this->assertEquals('', $entry->getTitle());
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\ACS\ACS::create
     */
    public function createJournalArticleWithTitle(): void
    {
        $acs = new ACS();
        $expectedOutput = 'Klingler, J. Influence of Pretreatment on Sodium Powder. Chem. Mater. 2005, 17, 2755-2768.';

        $acs->parse($expectedOutput);

        /** @var Entries $entries */
        $entries = $acs->retrieve();

        $this->assertEquals($expectedOutput, $acs->create($entries));
    }

    /**
     * @test
     * @covers \Geissler\Converter\Standard\ACS\ACS::create
     */
    public function createJournalArticleWithoutTitle(): void
    {
        $acs = new ACS();
        $expectedOutput = 'Klingler, J. Chem. Mater. 2005, 17, 2755-2768.';

        $acs->parse($expectedOutput);

        /** @var Entries $entries */
        $entries = $acs->retrieve();

        $this->assertEquals($expectedOutput, $acs->create($entries));
    }
}
