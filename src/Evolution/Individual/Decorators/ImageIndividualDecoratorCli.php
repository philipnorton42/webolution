<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

/**
 * Class ImageIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class ImageIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        $imageMatrix = $this->getIndividual()->getObject()->getImageMatrix();

        foreach ($imageMatrix as $xId => $x) {
            foreach ($x as $yId => $y) {
                $output .= $y;
            }
            $output .= PHP_EOL;
        }

        return trim($output);
    }
}
