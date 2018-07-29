<?php

namespace Hashbangcode\Webolution\Evolution\Individual;

use Hashbangcode\Webolution\Evolution\Individual\Exception\IndividualNotFoundException;
use Hashbangcode\Webolution\Evolution\Individual\IndividualInterface;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class IndividualFactory.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\
 */
class IndividualFactory
{

    /**
     * Given a population object and a type of render, find and instansiate the object.
     *
     * @param \Hashbangcode\Webolution\Type\TypeInterface $type
     *   The individual.
     *
     * @return \Hashbangcode\Webolution\Evolution\Population\\PopulationInterface
     *   The recorator.
     *
     * @throws IndividualNotFoundException
     */
    public static function getIndividual(TypeInterface $type)
    {
        // Extract the class name.
        $class = get_class($type);

        // Grab the parts of the class.
        $class = explode('\\', $class);

        // Reconstruct the class name that we need.
        $individualClass = '\\' . $class[0];
        $individualClass .= '\\' . $class[1];
        $individualClass .= '\\' . 'Evolution';
        $individualClass .= '\\' . 'Individual';
        $individualClass .= '\\' . array_pop($class) . 'Individual';

        if (!class_exists($individualClass)) {
            throw new IndividualNotFoundException(' class ' . $individualClass . ' not found.');
        }

        $decorator = new $individualClass($type);
        return $decorator;
    }
}
