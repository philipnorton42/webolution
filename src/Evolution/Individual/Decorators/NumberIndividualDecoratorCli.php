<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

/**
 * Class NumberIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class NumberIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getNumber() . PHP_EOL;
    }
}
