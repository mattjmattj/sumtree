<?php

namespace Sumtree\Test;

use PHPUnit\Framework\TestCase;
use Sumtree\Sumtree;

final class SumtreeTest extends TestCase
{
    public function testAddAndGetElements(): void
    {
        $sumtree = new Sumtree(4);
        $sumtree->add('a', 5);
        $sumtree->add('b', 2);
        $sumtree->add('c', 8);
        $sumtree->add('d', 4);

        // aaaaabbccccccccdddd
        $this->assertEquals('a', $sumtree->getElement(0));
        $this->assertEquals('a', $sumtree->getElement(1));
        $this->assertEquals('a', $sumtree->getElement(5));
        $this->assertEquals('b', $sumtree->getElement(6));
        $this->assertEquals('c', $sumtree->getElement(10));
        $this->assertEquals('d', $sumtree->getElement(18));
        $this->assertEquals('d', $sumtree->getElement(19));
    }

    public function testSumIsAccurate(): void
    {
        $sumtree = new Sumtree(4);
        $sumtree->add('a', 5);
        $sumtree->add('b', 2);
        $sumtree->add('c', 8);
        $sumtree->add('d', 4);

        $this->assertEquals(19, $sumtree->sum());
    }

    public function testMaxIsAccurate(): void
    {
        $sumtree = new Sumtree(4);
        $sumtree->add('a', 5);
        $sumtree->add('b', 2);
        $sumtree->add('c', 8);
        $sumtree->add('d', 4);

        $this->assertEquals(8, $sumtree->max());
    }

    public function testIsRolling(): void
    {
        $sumtree = new Sumtree(4);
        $sumtree->add('a', 5);
        $sumtree->add('b', 2);
        $sumtree->add('c', 8);
        $sumtree->add('d', 4);

        $sumtree->add('new a', 2);

        $this->assertEquals(16, $sumtree->sum());

        $this->assertEquals('new a', $sumtree->getElement(0));
        $this->assertEquals('new a', $sumtree->getElement(1));
        $this->assertEquals('new a', $sumtree->getElement(2));
        $this->assertEquals('b', $sumtree->getElement(3));
    }
}