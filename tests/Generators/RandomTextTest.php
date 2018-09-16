<?php

namespace Hashbangcode\Webolution\Test\Generators;

use Hashbangcode\Webolution\Generators\RandomText;

/**
 * Test class for Color
 */
class RandomTextTest extends \PHPUnit_Framework_TestCase
{
    use RandomText;

    public function testCreateLetter()
    {
        $letter = $this->getRandomLetter();
        $this->assertTrue(is_string($letter));
        $this->assertEquals(1, strlen($letter));
    }

    public function testCreateText()
    {
        $letter = $this->generateRandomText();
        $this->assertTrue(is_string($letter));
        $this->assertEquals(7, strlen($letter));
    }
}