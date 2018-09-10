<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\IndividualInterface;

/**
 * Class IndividualDecorator.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
abstract class IndividualDecorator implements IndividualDecoratorInterface
{
    /**
     * @var \Hashbangcode\Webolution\Evolution\Individual\IndividualInterface The individual object.
     */
    protected $individual;

    /**
     * Get the individual.
     *
     * @return IndividualInterface
     *   The individual.
     */
    public function getIndividual(): IndividualInterface
    {
        return $this->individual;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(IndividualInterface $individual)
    {
        $this->individual = $individual;
    }
}
