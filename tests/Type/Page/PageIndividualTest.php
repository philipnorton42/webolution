<?php

namespace Hashbangcode\Webolution\Test\Type\Page;

use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Page\PageIndividual;
use Hashbangcode\Webolution\Type\Page\Page;
use PHPUnit\Framework\TestCase;

/**
 * Test class for PageIndividual.
 */
class PageIndividualTest extends TestCase
{

    public function testCreateIndividual()
    {
        $object = new PageIndividual(new Page(new Element()));
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Page\PageIndividual', $object);

        $this->assertEquals('1', $object->getName());
        $this->assertEquals('div', $object->getSpecies());
    }

    public function testMutateIndividual()
    {
        $page = new Page(new Element());
        $object = new PageIndividual($page);
        $object->mutate(-100);
        $this->assertEquals('div', $object->getObject()->getBody()->getType());
    }
}
