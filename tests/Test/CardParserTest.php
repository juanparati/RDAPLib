<?php


namespace Juanparati\RDAPLib\Tests;


use Juanparati\RDAPLib\Helpers\RdapJCardParser;
use Juanparati\RDAPLib\Models\Helpers\CardModel;
use PHPUnit\Framework\TestCase;


/**
 * Class CardParserTest.
 *
 * Test the card parser and model.
 *
 * @package Juanparati\RDAPLib\Tests
 */
class CardParserTest extends TestCase
{

    public function testCard()
    {

        $data = file_get_contents(__DIR__ . '/../Resources/jcard.json');
        $data = json_decode($data, true);

        $card = RdapJCardParser::parse($data);

        $this->assertTrue($card instanceof CardModel);
        $this->assertEquals('4.0', $card->version);
        $this->assertEquals("Line1.\nLine2\nSpain", $card->adr);
        $this->assertEquals('ADMIN TEST', $card->fn);
        $this->assertCount(5, $card->email);
        $this->assertEquals('test3@example.net',  $card->email[3]);
        $this->assertEquals('email', $card->getWithAttr('email')[3]['type']);
    }
}
