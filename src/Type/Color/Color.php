<?php

namespace Hashbangcode\Webolution\Type\Color;

use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class Color.
 *
 * @package Hashbangcode\Webolution\Type\Color
 */
class Color implements TypeInterface
{

    /**
     * @var int|null The amount of red.
     */
    private $red = null;

    /**
     * @var int|null The amount of green.
     */
    private $green = null;

    /**
     * @var int|null The amount of blue.
     */
    private $blue = null;

    /**
     * @var float|null The hue of the color.
     */
    private $hue = null;

    /**
     * @var float|null The hue2 value of the color.
     */
    private $hue2 = null;

    /**
     * @var float|null The croma value of the color.
     */
    private $croma = null;

    /**
     * @var float|null The croma2 value of the color.
     */
    private $croma2 = null;

    /**
     * @var float|null The value of the color.
     */
    private $value = null;

    /**
     * @var float|null The lightness of the color.
     */
    private $lightness = null;

    /**
     * @var float|null The luma, based on Rec. 601 NTSC primaries.
     */
    private $luma = null;

    /**
     * @var float|null The HSV saturation value of the color.
     */
    private $hsv_saturation = null;

    /**
     * @var float|null The HSL saturation value of the color.
     */
    private $hsl_saturation = null;

    /**
     * @var float|null The HSI saturation value of the color.
     */
    private $hsi_saturation = null;

    /**
     * Color constructor.
     *
     * @param int $red
     *   The red level, between 0 and 255.
     * @param int $green
     *   The green level, between 0 and 255.
     * @param int $blue
     *   The blue level, between 0 and 255.
     *
     * @throws Exception\InvalidRGBValueException
     *   If invalid numbers are given for color values.
     */
    public function __construct($red, $green, $blue)
    {
        if (!is_numeric($red) || $red < 0 || $red > 255) {
            throw new Exception\InvalidRGBValueException('Incorrect value for Red in Color class');
        }

        if (!is_numeric($green) || $green < 0 || $green > 255) {
            throw new Exception\InvalidRGBValueException('Incorrect value for Green in Color class');
        }

        if (!is_numeric($blue) || $blue < 0 || $blue > 255) {
            throw new Exception\InvalidRGBValueException('Incorrect value for Blue in Color class');
        }

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    /**
     * Get the RGB Value of a Color.
     *
     * @return string The RGB value.
     */
    public function getRGB()
    {
        return str_pad((string) $this->getRed(), 3, '0', STR_PAD_LEFT) .
            str_pad((string) $this->getGreen(), 3, '0', STR_PAD_LEFT) .
            str_pad((string) $this->getBlue(), 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the red value of the color.
     *
     * @return int|null
     *   The red value.
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Set the red value of the color.
     *
     * @param int $red
     *   The red value.
     */
    public function setRed($red)
    {
        $this->red = $red;
    }

    /**
     * Get the green value of the color.
     *
     * @return int|null
     *   The green value.
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * Set the green value of the color.
     *
     * @param int $green
     *   The green value.
     */
    public function setGreen($green)
    {
        $this->green = $green;
    }

    /**
     * Get the blue value of the color.
     *
     * @return int|null
     *   The blue value.
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Set the blue value of the color.
     *
     * @param int $blue
     *   The blue value.
     */
    public function setBlue($blue)
    {
        $this->blue = $blue;
    }

    /**
     * Get the croma value of the color.
     *
     * @return null|float
     *   The croma value.
     */
    public function getCroma()
    {
        return $this->croma;
    }

    /**
     * Set the croma.
     *
     * @param float $croma
     *   The croma.
     */
    public function setCroma($croma)
    {
        $this->croma = $croma;
    }

    /**
     * Get croma2.
     *
     * @return null|float
     *   The croma2.
     */
    public function getCroma2()
    {
        return $this->croma2;
    }

    /**
     * Set croma2.
     *
     * @param float $croma2
     *   The croma2.
     */
    public function setCroma2($croma2)
    {
        $this->croma2 = $croma2;
    }

    /**
     * Get the HSI saturation.
     *
     * @return null|float
     *   The HSI saturation.
     */
    public function getHsiSaturation()
    {
        $this->calculateHsiSaturation();
        return $this->hsi_saturation;
    }

    /**
     * Set the HSI saturation.
     *
     * @param float $hsi_saturation
     *   The hsi saturation.
     */
    public function setHsiSaturation($hsi_saturation)
    {
        $this->hsi_saturation = $hsi_saturation;
    }

    /**
     * Calculate the HSI saturation values for the color.
     *
     * The values are then stored in the current object.
     */
    protected function calculateHsiSaturation()
    {
        $red = $this->red / 255;
        $green = $this->green / 255;
        $blue = $this->blue / 255;

        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);

        if ($max - $min === 0) {
            $this->setHsiSaturation(0);
        } else {
            $this->setHsiSaturation(1 - $min / (($red + $green + $blue) / 3));
        }
    }

    /**
     * Get the HSL saturation value for the color. This method calculates the value if it isn't set.
     *
     * @return null|float
     *   The HSL saturation value.
     */
    public function getHslSaturation()
    {
        $this->calculateHSL();
        return $this->hsl_saturation;
    }

    /**
     * Set the HSL saturation.
     *
     * @param float $hsl_saturation
     *   The HSL saturation.
     */
    public function setHslSaturation($hsl_saturation)
    {
        $this->hsl_saturation = $hsl_saturation;
    }

    /**
     * Calculate the HSL saturation values for the color.
     *
     * The values are then stored in the current object.
     */
    protected function calculateHSL()
    {
        $hue = 0;

        $red = $this->red / 255;
        $green = $this->green / 255;
        $blue = $this->blue / 255;

        $chroma_min = min($red, $green, $blue);
        $chroma_max = max($red, $green, $blue);

        $lightness = ($chroma_max + $chroma_min) / 2;
        $delta = $chroma_max - $chroma_min;

        if ($delta == 0) {
            $hue = $saturation = 0; // achromatic
        } else {
            $saturation = $delta / (1 - abs(2 * $lightness - 1));

            switch ($chroma_max) {
                case $red:
                    $hue = 60 * fmod((($green - $blue) / $delta), 6);
                    if ($blue > $green) {
                        //$hue += 360;
                    }
                    break;

                case $green:
                    $hue = 60 * (($blue - $red) / $delta + 2);
                    break;

                case $blue:
                    $hue = 60 * (($red - $green) / $delta + 4);
                    break;
            }
        }

        $this->hue = round($hue, 4);
        $this->hsl_saturation = round($saturation, 4);
        $this->lightness = round($lightness, 4);
    }

    /**
     * Get the HSV saturation.
     *
     * @return null|float
     *   The HSV saturation.
     */
    public function getHsvSaturation()
    {
        $this->calcualteHSV();
        return $this->hsv_saturation;
    }

    /**
     * Set the HSV saturation.
     *
     * @param float $hsv_saturation
     *   The HSV saturation.
     */
    public function setHsvSaturation($hsv_saturation)
    {
        $this->hsv_saturation = $hsv_saturation;
    }

    /**
     * Calculate the HSV color wheel values for the color.
     */
    protected function calcualteHSV()
    {
        $red = $this->red / 255;
        $green = $this->green / 255;
        $blue = $this->blue / 255;

        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);

        switch ($max) {
            case 0:
                // If the max value is 0.
                $this->hue = 0;
                $this->hsv_saturation = 0;
                $this->value = 0;
                break;
            case $min:
                // If the maximum and minimum values are the same.
                $this->hue = 0;
                $this->hsv_saturation = 0;
                $this->value = round($max, 4);
                break;
            default:
                $delta = $max - $min;
                if ($red == $max) {
                    $this->hue = 0 + ($green - $blue) / $delta;
                } elseif ($green == $max) {
                    $this->hue = 2 + ($blue - $red) / $delta;
                } else {
                    $this->hue = 4 + ($red - $green) / $delta;
                }
                $this->hue *= 60;
                if ($this->hue < 0) {
                    $this->hue += 360;
                }
                $this->hsv_saturation = $delta / $max;
                $this->value = round($max, 4);
        }

        // Ensure that Luma is also calculated.
        $this->calculateLuma();
    }

    /**
     * Calculate the luma value for the color.
     */
    public function calculateLuma()
    {
        // Luma is calculated by 0.2126R + 0.7152G + 0.0722B
        $luma = (0.2126 * $this->red) + (0.7152 * $this->green) + (0.0722 * $this->blue);
        $this->luma = $luma;
    }

    /**
     * Get the hue.
     *
     * @return null|float
     *   The hue.
     */
    public function getHue()
    {
        $this->calcualteHSV();
        return $this->hue;
    }

    /**
     * Set the hue.
     *
     * @param float $hue
     *   The hue.
     */
    public function setHue($hue)
    {
        $this->hue = $hue;
    }

    /**
     * Get the hue2.
     *
     * @return null|float
     *   The hue2.
     */
    public function getHue2()
    {
        return $this->hue2;
    }

    /**
     * Set hue2.
     *
     * @param float $hue2
     *   The hue2.
     */
    public function setHue2($hue2)
    {
        $this->hue2 = $hue2;
    }

    /**
     * Get the lightness.
     *
     * @return null|float
     *   The lightness.
     */
    public function getLightness()
    {
        $this->calculateHSL();
        return $this->lightness;
    }

    /**
     * Set the lightness.
     *
     * @param float $lightness
     *   The lightness value to set.
     */
    public function setLightness($lightness)
    {
        $this->lightness = $lightness;
    }

    /**
     * Get he luma.
     *
     * @return null|float
     *   The current luma.
     */
    public function getLuma()
    {
        $this->calcualteHSV();
        return $this->luma;
    }

    /**
     * Set the luma.
     *
     * @param float $luma
     *   The luma to set
     */
    public function setLuma($luma)
    {
        $this->luma = $luma;
    }

    /**
     * Get the value.
     *
     * @return null|float
     *   The value.
     */
    public function getValue()
    {
        $this->calcualteHSV();
        return $this->value;
    }

    /**
     * The set value.
     *
     * @param float $value
     *   The value of the color.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Randomise the color.
     *
     * @return array
     *   The random color.
     */
    public function randomise()
    {
        $this->resetcolor();

        $this->setRed(ceil(mt_rand(0, 255)));
        $this->setGreen(ceil(mt_rand(0, 255)));
        $this->setBlue(ceil(mt_rand(0, 255)));

        return $this->getColorArray();
    }

    /**
     * Reset the color values. Useful when randomising the color or calculating new values.
     */
    private function resetColor()
    {
        $this->red = null;
        $this->green = null;
        $this->blue = null;

        $this->resetColorGeometry();
    }

    /**
     * Utility function to reset all the calculated color geometry.
     *
     * This is used when alterations are made the the color that would mean the existing color geometry is incorrect.
     * This doesn't calculate the new values as this is done when they are called for e.g. the lightness is calculated
     * before being returned by the getLightness() method.
     */
    private function resetColorGeometry()
    {
        $this->hue = null;
        $this->hue2 = null;

        $this->croma = null;
        $this->croma2 = null;

        $this->value = null;
        $this->lightness = null;

        $this->luma = null;

        $this->hsv_saturation = null;
        $this->hsl_saturation = null;
        $this->hsi_saturation = null;
    }

    /**
     * Get a standard array of red, green, and blue.
     *
     * @return array A standard RGB color array.
     */
    public function getColorArray()
    {
        return array(
            'red',
            'green',
            'blue'
        );
    }

    /**
     * Generate a hex value of the color based on the current RGB values.
     *
     * @return string
     *   The hex value.
     */
    public function getHex()
    {
        $rgb['red'] = str_pad(dechex($this->getRed()), 2, '0', STR_PAD_LEFT);
        $rgb['green'] = str_pad(dechex($this->getGreen()), 2, '0', STR_PAD_LEFT);
        $rgb['blue'] = str_pad(dechex($this->getBlue()), 2, '0', STR_PAD_LEFT);

        return strtoupper(implode($rgb));
    }

    /**
     * Convenience method that renders out the color statistics for this color.
     *
     * @return string
     *   The full statistics of the color.
     */
    public function renderColorStatistics()
    {
        $output = '';

        $output .= 'Red: ' . $this->getRed() . PHP_EOL;
        $output .= 'Green: ' . $this->getGreen() . PHP_EOL;
        $output .= 'Blue: ' . $this->getBlue() . PHP_EOL;
        $output .= 'Hex: ' . $this->getHex() . PHP_EOL;
        $output .= 'Croma: ' . $this->getCroma() . PHP_EOL;
        $output .= 'Croma2: ' . $this->getCroma2() . PHP_EOL;
        $output .= 'Hue: ' . $this->getHue() . PHP_EOL;
        $output .= 'Hue2: ' . $this->getHue2() . PHP_EOL;
        $output .= 'Hsi Saturation: ' . $this->getHsiSaturation() . PHP_EOL;
        $output .= 'Hsl Saturation: ' . $this->getHslSaturation() . PHP_EOL;
        $output .= 'Hsv Saturation: ' . $this->getHsvSaturation() . PHP_EOL;
        $output .= 'Lightness: ' . $this->getLightness() . PHP_EOL;
        $output .= 'Value: ' . $this->getValue() . PHP_EOL;

        return $output;
    }
}
