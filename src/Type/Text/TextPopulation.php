<?php

namespace Hashbangcode\Webolution\Type\Text;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class TextPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class TextPopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = TextIndividual::generateRandomTextIndividual();
        }
        $this->individuals[] = $individual;
    }

    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        uasort($this->individuals, function ($a, $b) {
            $aValue = $a->getFitness();
            $bValue = $b->getFitness();

            if ($aValue == $bValue) {
                return 0;
            }

            return ($aValue < $bValue) ? -1 : 1;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // Get two individuals from the population.
        $individuals = $this->getRandomIndividuals(2);

        // Make sure we have Individuals to use.
        if ($individuals == false) {
            // Add a clone of a individual individual.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);

            // Don't do anything else.
            return;
        }

        $text1 = str_split($individuals[0]->getObject()->getText());
        $text2 = str_split($individuals[1]->getObject()->getText());

        $newText = '';

        $text1Count = count($text1);
        $text2Count = count($text2);


        if ($text1Count >= $text2Count) {
            foreach ($text1 as $id => $letter) {
                if ($id % 2 || !isset($text2[$id])) {
                    $newText .= $text1[$id];
                } elseif (isset($text2[$id])) {
                    $newText .= $text2[$id];
                }
            }
        } elseif ($text1Count < $text2Count) {
            foreach ($text2 as $id => $letter) {
                if ($id % 2 || !isset($text1[$id])) {
                    $newText .= $text2[$id];
                } elseif (isset($text1[$id])) {
                    $newText .= $text1[$id];
                }
            }
        }


        // Create a new individual.
        $individualNew = TextIndividual::generateFromString($newText);

        // Add the individual to the population.
        $this->addIndividual($individualNew);
    }
}
