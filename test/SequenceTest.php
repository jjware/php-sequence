<?php
declare(strict_types=1);

use JJWare\Utils\Sequence\Sequence;
use JJWare\Utils\Sequence\Cons;
use JJWare\Utils\Sequence\Nil;

use JJWare\Utils\Option\Option;

use PHPUnit\Framework\TestCase;

class SequenceTest extends TestCase
{
    public function testNil()
    {
        $this->assertEquals(Sequence::nil(), new Nil());
    }

    public function testCons()
    {
        $this->assertEquals(Sequence::cons(1, Sequence::nil()), new Cons(1, Sequence::nil()));
    }

    public function testConsHead()
    {
        $s = Sequence::cons("a", Sequence::nil());
        $this->assertEquals("a", $s->head());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testNilHead()
    {
        $s = Sequence::nil();
        $s->head();
    }

    public function testConsTail()
    {
        $s = Sequence::cons("a", Sequence::nil());
        $this->assertEquals(Sequence::nil(), $s->tail());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testNilTail()
    {
        $s = Sequence::nil();
        $s->tail();
    }

    public function testConsHeadOption()
    {
        $s = Sequence::cons("a", Sequence::nil());
        $this->assertEquals(Option::some("a"), $s->headOption());
    }

    public function testNilHeadOption()
    {
        $s = Sequence::nil();
        $this->assertEquals(Option::none(), $s->headOption());
    }
}
