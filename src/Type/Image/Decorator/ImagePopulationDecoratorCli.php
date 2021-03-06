<?php

namespace Hashbangcode\Webolution\Type\Image\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class ImagePopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Image\Decorator
 */
class ImagePopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new ImageIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render();
            $output .= PHP_EOL . PHP_EOL;
        }

        return $output;
    }
}
