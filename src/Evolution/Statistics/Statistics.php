<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics;

use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Class Statistics.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class Statistics implements StatisticsInterface
{
    /**
     * The max fitness.
     *
     * @var int
     */
    protected $maxFitness = 0;

    /**
     * The min fitness.
     *
     * @var int
     */
    protected $minFitness = 0;

    /**
     * The median fitness.
     *
     * @var int
     */
    protected $medianFitness = 0;

    /**
     * The mean fitness.
     *
     * @var int
     */
    protected $meanFitness = 0;

    /**
     * Max fitness individual.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    protected $maxFitnessIndividual;

    /**
     * Min fitness individual.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    protected $minFitnessIndividual;

    /**
     * Median fitness individual.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    protected $medianFitnessIndividual;

    /**
     * {@inheritdoc}
     */
    public function getMedianFitness(): int
    {
        return $this->medianFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMedianFitness(int $medianFitness)
    {
        $this->medianFitness = $medianFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function getMedianFitnessIndividual()
    {
        return $this->medianFitnessIndividual;
    }

    /**
     * {@inheritdoc}
     */
    public function setMedianFitnessIndividual($medianFitnessIndividual)
    {
        $this->medianFitnessIndividual = $medianFitnessIndividual;
        $this->setMedianFitness($medianFitnessIndividual->getFitness());
    }

    /**
     * {@inheritdoc}
     */
    public function getMinFitness(): int
    {
        return $this->minFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMinFitness(int $minFitness)
    {
        $this->minFitness = $minFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxFitness(): int
    {
        return $this->maxFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxFitness(int $maxFitness)
    {
        $this->maxFitness = $maxFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateMeanFitness(PopulationInterface $population)
    {
        $fitnessSum = 0;
        foreach ($population->getIndividuals() as $individual) {
            $fitnessSum += $individual->getFitness();
        }
        $this->setMeanFitness($fitnessSum / $population->getLength());
        return $this->getMeanFitness();
    }

    /**
     * {@inheritdoc}
     */
    public function getMeanFitness(): int
    {
        return $this->meanFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMeanFitness(int $meanFitness)
    {
        $this->meanFitness = $meanFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function extractFitnessIndividuals(PopulationInterface $population)
    {
        // Sort the current population.
        $population->sort();

        foreach ($population->getIndividuals() as $key => $individual) {
            $fitness = $individual->getFitness();

            // Store Max.
            if (!is_object($this->getMaxFitnessIndividual())
                || $fitness > $this->getMaxFitnessIndividual()->getFitness()
            ) {
                $this->setMaxFitnessIndividual($individual);
            }

            // Store Min.
            if (!is_object($this->getMinFitnessIndividual())
                || $fitness < $this->getMinFitnessIndividual()->getFitness()
            ) {
                $this->setMinFitnessIndividual($individual);
            }
        }

        // Get Median.
        $individuals = $population->getIndividuals();
        $slicedArray = array_slice($individuals, floor(count($individuals) / 2), 1);
        $this->setMedianFitnessIndividual(array_pop($slicedArray));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxFitnessIndividual()
    {
        return $this->maxFitnessIndividual;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxFitnessIndividual($maxFitnessIndividual)
    {
        $this->maxFitnessIndividual = $maxFitnessIndividual;
        $this->setMaxFitness($maxFitnessIndividual->getFitness());
    }

    /**
     * {@inheritdoc}
     */
    public function getMinFitnessIndividual()
    {
        return $this->minFitnessIndividual;
    }

    /**
     * {@inheritdoc}
     */
    public function setMinFitnessIndividual($minFitnessIndividual)
    {
        $this->minFitnessIndividual = $minFitnessIndividual;
        $this->setMinFitness($minFitnessIndividual->getFitness());
    }
}
