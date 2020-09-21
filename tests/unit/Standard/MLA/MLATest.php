<?php


namespace Geissler\Converter\Standard\MLA;

use PHPUnit\Framework\TestCase;

/**
 * @author Níckolas Da Silva <nickolas@phpsp.org.br>
 * @copyright ResearchGate GmbH
 * @license MIT
 *
 * @see https://web.archive.org/web/20180805122909/https://library.stritch.edu/getmedia/42a8f9b1-4241-44f8-9f01-98a5fe659183/MLAStyleGuide (Arrangement of Entries (MLA 111-115)
 */
class MLATest extends TestCase
{
    /**
     * @test
     * @covers \Geissler\Converter\Standard\MLA\MLA::parse
     */
    public function parseWithEmptyStringsReturnsFalse(): void
    {
        $mla = new MLA();
        $this->assertFalse($mla->parse(''));
    }
}
