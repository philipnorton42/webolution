<?php

namespace Hashbangcode\Webolution\Evolution\Individual;

/**
 * Interface IndividualInterface.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual
 */
interface IndividualInterface
{
    /**
     * Get the underlying Type object.
     *
     * @return object
     *   The type object.
     */
    public function getObject();

    /**
     * Mutate the individual.
     *
     * @param int $mutationFactor
     *   The mutation factor.
     * @param int $mutationAmount
     *   The mutation amount.
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1);

    /**
     * Get the fitness of the individual.
     *
     * The fitness should be a positive integer.
     *
     * @param string $type
     *   The type of fitness to calculate.
     *
     * @return int
     *   The fitness of the individual.
     */
    public function getFitness($type = '');
}
