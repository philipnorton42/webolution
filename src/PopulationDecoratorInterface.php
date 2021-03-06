<?php

namespace Hashbangcode\Webolution;

/**
 * Interface PopulationDecoratorInterface.
 *
 * @package Hashbangcode\Webolution
 */
interface PopulationDecoratorInterface
{

    /**
     * PopulationDecoratorInterface constructor.
     *
     * @param PopulationInterface $population
     *   The population to wrap.
     */
    public function __construct(PopulationInterface $population);

    /**
     * Render the population object.
     *
     * @return mixed
     *   The rendered output.
     */
    public function render();
}
