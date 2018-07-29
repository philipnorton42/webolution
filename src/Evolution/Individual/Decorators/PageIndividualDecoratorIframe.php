<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\IndividualFactory;
use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Type\Element\Element;

/**
 * Class PageIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class PageIndividualDecoratorIframe extends PageIndividualDecoratorHtml
{
    /**
     * The type of rendering.
     *
     * @var string
     */
    protected $type = 'html';

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $pageHtml = parent::render();

        $iframe = '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $pageHtml . '\'></iframe>';

        // Return page markup.
        return $iframe;
    }
}
