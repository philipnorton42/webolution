<?php

namespace Hashbangcode\Webolution\Type\Element;

use Hashbangcode\Webolution\Individual;

/**
 * Class ElementIndividual.
 *
 * @package Hashbangcode\Webolution\Individual
 */
class ElementIndividual extends Individual
{
    /**
     * Generate an ElementIndividual object.
     *
     * @param string $type
     *   The type of element to generate.
     *
     * @return ElementIndividual
     *   The obejct.
     */
    public static function generateFromElementType($type)
    {
        return new self(new Element($type));
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        // The name of the ElementIndividual is the number of elements.
        return count($this->getObject()->getAllElements());
    }

    /**
     * {@inheritdoc}
     */
    public function getSpecies(): string
    {
        // The species of the ElementIndividual is number of different types.
        return (string) count($this->getObject()->getAllTypes());
    }

    /**
     * {@inheritdoc}
     *
     * Possible actions to take during mutation.
     * - Alter attributes (2/10).
     * - Add attributes (2/10).
     * - Add children (1/10).
     * - Remove children (1/10).
     * - Alter tag (1/10).
     *
     * This should not alter the tag itself. Also, certain elements
     * should only get certain children. For example, a ul
     * or a ol element should only get a li or a.
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100);
        $action = $action + $mutationFactor;

        // Get the element.
        $element = $this->getObject();

        if ($action <= 20 && count($element->getAttributes()) > 0) {
            $this->mutateAttribute();
        } elseif ($action > 20 && $action <= 40) {
            $this->addAttributeToRandomElement();
        } elseif ($action > 40 && $action <= 50) {
            $this->addChildrenElement();
        } elseif ($action > 50 && $action <= 55) {
            $this->getObject()->removeRandomChild();
        } elseif ($action > 55 && $action <= 80) {
            $this->mutateTag();
        }
    }

    /**
     * Alter the tag of the Element object.
     */
    public function mutateTag()
    {
        $availableTags = $this->getObject()->getAvailableChildTypes();
        $foundTag = array_search($this->getObject()->getType(), $availableTags);

        if ($foundTag != false) {
            unset($availableTags[$foundTag]);
        }

        if (count($availableTags) > 0) {
            $newTag = array_rand($availableTags);
            $this->getObject()->setType($availableTags[$newTag]);
        }
    }

    /**
     * Add an attribute to a random element.
     */
    public function addAttributeToRandomElement()
    {
        $element = $this->getObject()->getRandomElement();

        $attributes = [
            'id',
            'class',
        ];

        $attribute = $attributes[array_rand($attributes)];

        $element->setAttribute($attribute, $element->generateRandomText(5));
    }

    /**
     * Add a child element to a random place in the element object.
     */
    public function addChildrenElement()
    {
        // Add children element.
        $randomElement = $this->getObject()->getRandomElement();
        $child_types = $randomElement->getAvailableChildTypes($randomElement->getType());
        $child_type = $child_types[array_rand($child_types)];
        $newElement = new Element($child_type);
        $randomElement->addChild($newElement);
    }

    /**
     * Mutate an attribute on the object.
     */
    public function mutateAttribute()
    {
        $element = $this->getObject();

        $attributes = $element->getAttributes();

        $random_attribute = array_rand($attributes);
        $letters = range('a', 'z');
        $letter = $letters[array_rand($letters)];

        $attribute_value = $attributes[$random_attribute] . $letter;

        if (strlen($attribute_value) > 10) {
            // Don't let the attribute get longer than 10 characters.
            $attribute_value = substr($attribute_value, -8);
        }

        $attributes[$random_attribute] = $attribute_value;

        $element->setAttributes($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = ''): float
    {
        $fitness = 0;

        /** @var \Hashbangcode\Webolution\Type\Element\Element $element */
        $element = $this->getObject();

        // Get the number of elements contained within the object.
        $elements = $element->getAllElements();
        $fitness += count($elements);

        // Get the number of classes in the element.
        $classes = $element->getAllClasses();
        $fitness += count($classes);

        // Get the number of types of elements.
        $types = $element->getAllTypes();
        $fitness += count($types);

        return $fitness;
    }
}
