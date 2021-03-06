<?php

namespace Hashbangcode\Webolution\Test\Type\Color;

use Hashbangcode\Webolution\Type\Color\Color;
use Hashbangcode\Webolution\Type\Color\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Color
 */
class ColorTest extends TestCase
{
    public function testCreateColorFromStrings()
    {
        $color = new Color('100', '100', '100');
        $this->assertEquals(100, $color->getRed());
        $this->assertEquals(100, $color->getGreen());
        $this->assertEquals(100, $color->getBlue());
        $this->assertEquals('100100100', $color->getRGB());
    }

    public function testCreateColorFromIntegers()
    {
        $color = new Color(100, 100, 100);
        $this->assertEquals(100, $color->getRed());
        $this->assertEquals(100, $color->getGreen());
        $this->assertEquals(100, $color->getBlue());
        $this->assertEquals('100100100', $color->getRGB());
    }

    public function testRandomiseColor()
    {
        $color = new Color(0, 0, 0);
        $color->randomise();

        $this->assertGreaterThanOrEqual(0, $color->getRed());
        $this->assertLessThanOrEqual(255, $color->getRed());

        $this->assertGreaterThanOrEqual(0, $color->getGreen());
        $this->assertLessThanOrEqual(255, $color->getGreen());

        $this->assertGreaterThanOrEqual(0, $color->getBlue());
        $this->assertLessThanOrEqual(255, $color->getBlue());
    }

    /**
     * @dataProvider colorData
     */
    public function testConvertToHex($hex, $rgb, $hsl)
    {
        $color = new Color($rgb[0], $rgb[1], $rgb[2]);

        $this->assertEquals($rgb[0], $color->getRed());
        $this->assertEquals($rgb[1], $color->getGreen());
        $this->assertEquals($rgb[2], $color->getBlue());

        $this->assertEquals($hex, $color->getHex());
    }

    /**
     * Data provider for color analysis.
     *
     * @return array
     */
    public function colorData()
    {
        return array(
            array('hex' => '000000', 'rgb' => array(0, 0, 0), 'hsl' => array(0, 0, 0)),
            array('hex' => 'FFFFFF', 'rgb' => array(255, 255, 255), 'hsl' => array(0, 0, 1)),
            array('hex' => 'FF0000', 'rgb' => array(255, 0, 0), 'hsl' => array(0, 1, 0.5)),
            array('hex' => '00FF00', 'rgb' => array(0, 255, 0), 'hsl' => array(120, 1, 0.5)),
            array('hex' => '0000FF', 'rgb' => array(0, 0, 255), 'hsl' => array(240, 1, 0.5)),
            array('hex' => 'FFFF00', 'rgb' => array(255, 255, 0), 'hsl' => array(60, 1, 0.5)),
            array('hex' => '00FFFF', 'rgb' => array(0, 255, 255), 'hsl' => array(180, 1, 0.5)),
            array('hex' => 'FF00FF', 'rgb' => array(255, 0, 255), 'hsl' => array(300, 1, 0.5)),
            array('hex' => 'C0C0C0', 'rgb' => array(192, 192, 192), 'hsl' => array(0, 0, 0.753)),
            array('hex' => '808080', 'rgb' => array(128, 128, 128), 'hsl' => array(0, 0, 0.5)),
            array('hex' => '800000', 'rgb' => array(128, 0, 0), 'hsl' => array(0, 1, 0.25)),
            array('hex' => '808000', 'rgb' => array(128, 128, 0), 'hsl' => array(60, 1, 0.25)),
            array('hex' => '008000', 'rgb' => array(0, 128, 0), 'hsl' => array(120, 1, 0.25)),
            array('hex' => '800080', 'rgb' => array(128, 0, 128), 'hsl' => array(300, 1, 0.25)),
            array('hex' => '008080', 'rgb' => array(0, 128, 128), 'hsl' => array(180, 1, 0.25)),
            array('hex' => '000080', 'rgb' => array(0, 0, 128), 'hsl' => array(240, 1, 0.25))
        );
    }

    /**
     * @dataProvider invalidRGBValues
     */
    public function testInvalidRBGValue($r, $g, $b)
    {
        $this->expectException('Hashbangcode\Webolution\Type\Color\Exception\InvalidRGBValueException');
        $color = new Color($r, $g, $b);
    }

    public function invalidRGBValues()
    {
        return array(
            array('r' => 10000, 'g' => 0, 'b' => 0),
            array('r' => 0, 'g' => 10000, 'b' => 0),
            array('r' => 0, 'g' => 0, 'b' => 10000),
            array('r' => 10000, 'g' => 10000, 'b' => 10000),
            array('r' => -10, 'g' => 0, 'b' => 0),
            array('r' => 0, 'g' => -10, 'b' => 0),
            array('r' => 0, 'g' => 0, 'b' => -10),
            array('r' => -10, 'g' => -10, 'b' => -10),
            array('r' => -10, 'g' => 10000, 'b' => 0),
            array('r' => 'red', 'g' => 0, 'b' => 0),
        );
    }

    public function testSetHsiSaturation()
    {
        // Max colour sets the hsi saturation to 0.
        $color = new Color(255, 255, 255);
        $color->setHsiSaturation(1);
        $this->assertEquals(0, $color->getHsiSaturation());

        // Mixed colour values set the hsi saturation to 1.
        $color = new Color(0, 125, 255);
        $color->setHsiSaturation(1);
        $this->assertEquals(1, $color->getHsiSaturation());
    }

    public function testSetHue2()
    {
        $color = new Color(255, 255, 255);
        $hue2 = 1;
        $color->setHue2($hue2);
        $this->assertEquals($hue2, $color->getHue2());
    }

    public function testSetLuma()
    {
        $color = new Color(0, 0, 0);
        $color->setLuma(1);
        $this->assertEquals(0.0, $color->getLuma());
    }

    public function testRenderColorStatistics()
    {
        $color = new Color(0, 0, 0);
        $statistics = $color->renderColorStatistics();
        $this->assertTrue(strstr($statistics, 'Red: 0') !== false);
        $this->assertTrue(strstr($statistics, 'Green: 0') !== false);
        $this->assertTrue(strstr($statistics, 'Blue: 0') !== false);
        $this->assertTrue(strstr($statistics, 'Hex: 000000') !== false);
        $this->assertTrue(strstr($statistics, 'Lightness: 0') !== false);
        $this->assertTrue(strstr($statistics, 'Value: 0') !== false);
    }
}
