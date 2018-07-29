<?php

namespace Hashbangcode\Webolution\Evolution\Population\Decorators;

/**
 * Class ColorPopulationDecoratorCss.
 *
 * @package Hashbangcode\Webolution\Evolution\Population\Decorators
 */
class ColorPopulationDecoratorCss extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new ColorIndividualDecoratorCss($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
