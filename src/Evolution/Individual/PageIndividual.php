<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Page\Page;

/**
 * Class PageIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class PageIndividual extends Individual
{
    /**
     * PageIndividual constructor.
     */
    public function __construct()
    {
        $this->object = new Page();
    }

    /**
     * {@inheritdoc}
     *
     * Possible actions to take during mutation.
     * - Chance to mutate body (9/10).
     * - Chance to mutate styles (1/10).
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100);

        // Get the body.
        $body = $this->getObject()->getBody();

        // Get styles.
        $styles = $this->getObject()->getStyles();

        if ($action <= $mutationFactor) {
            // Mutate styles.
            $randomStyle = $styles[array_rand($styles)];
            if (!($randomStyle instanceof \Hashbangcode\Wevolution\Evolution\Individual\Individual)) {
                // If the style is not an individual then wrap it so we can mutate it.
                $randomStyle = new StyleIndividual($randomStyle);
            }

            $randomStyle->mutate();

        } elseif ($action >= $mutationFactor) {
            // Mutate the body.
            if (!($body instanceof \Hashbangcode\Wevolution\Evolution\Individual\Individual)) {
                // If the body isn't an individual then wrap it so we can mutate it.
                $body = new ElementIndividual($body);
            }

            // Mutate body.
            $body->mutate();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        // @todo see how we can get a better fitness for pages.
        // Possible candidates include:
        // - number of elements
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function render($renderType = 'cli')
    {
        $output = '';
        switch ($renderType) {
            case 'html':
                $output .= $this->getObject()->render();
                break;
            case 'cli':
                // Intentional fall through.
            default:
                $output .= $this->getObject()->render();
        }
        return $output;
    }
}
