<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\TextIndividual;
use Hashbangcode\Wevolution\Type\Text\Text;

/**
 * Class TextPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class TextPopulation extends Population
{
    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

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
     *
     */
    public function sort()
    {
        sort($this->individuals);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = parent::render();
        switch ($this->getDefaultRenderType()) {
            case 'html':
                $output .= ' (' . $this->getLength() . ' items)<br>';
                break;
            case 'cli':
            default:
                $output .= ' (' . $this->getLength() . ' items)' . PHP_EOL;
                break;
        }
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // @todo implement this.
    }
}
