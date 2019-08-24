<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\PageIndividualDecoratorIframe;
use Prophecy\Prophet;

class PageIndividualDecoratorIframeTestTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $individualDecorator = new PageIndividualDecoratorIframe($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\PageIndividualDecoratorIframe', $individualDecorator);
    }

    public function testSimplePageCreation()
    {
        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn(null);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorIframe($individual->reveal());
        $output = $individualDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/pageiframe01.html', $output);
    }

    public function testPageCreationWithBody()
    {
        $body = new \Hashbangcode\Webolution\Type\Element\Element();

        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorIframe($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/pageiframe02.html', $output);
    }

    public function testPageCreationWithBodyAndStyle()
    {
        $body = new \Hashbangcode\Webolution\Type\Element\Element();

        $style = new \Hashbangcode\Webolution\Type\Style\Style('div.test', ['color' => 'red']);

        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([$style]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorIframe($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/pageiframe03.html', $output);
    }

    public function testPageCreationWithBodyAndStyleWithColorObject()
    {
        $body = new \Hashbangcode\Webolution\Type\Element\Element();

        $color = \Hashbangcode\Webolution\Evolution\Individual\ColorIndividual::generateFromHex('2CA02C');

        $style = new \Hashbangcode\Webolution\Type\Style\Style('div.test', ['color' => $color]);

        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([$style]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorIframe($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/pageiframe04.html', $output);
    }

    public function testSimplePageCreationWithSizedIframe()
    {
        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn(null);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorIframe($individual->reveal());
        $individualDecorator->setHeight(500);
        $individualDecorator->setWidth(500);

        $output = $individualDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/pageiframe05.html', $output);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
