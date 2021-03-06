<?php

namespace Hashbangcode\Webolution\Type\Page;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;
use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class PagePopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Do not sort pages.
    }

    /**
     * Add an individual.
     *
     * @param \Hashbangcode\Webolution\Individual|null $individual
     *   Add an individual.
     *
     * @return $this
     *   The current object.
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = PageIndividual::generateBlankPage();

            $element = new Element('div');
            $individual->getObject()->setBody($element);

            $style_object = new Style('div');
            $individual->getObject()->setStyle($style_object);
        }

        $this->individuals[] = $individual;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        if ($this->getIndividualCount() == 0) {
            return;
        }

        if ($this->getIndividualCount() == 1) {
            // Add a clone of a individual individual.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);
            return;
        }

        // Get two individuals from the population.
        $individuals = $this->getRandomIndividuals(2);

        $style = $individuals[0]->getObject()->getStyles();
        $body = $individuals[1]->getObject()->getBody();

        $newIndividual = PageIndividual::generateBlankPage();

        $newIndividual->getObject()->setBody($body);
        $newIndividual->getObject()->setStyles($style);

        $this->addIndividual($newIndividual);
    }
}
