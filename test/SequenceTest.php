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
}
