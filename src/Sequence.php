<?php

namespace JJWare\Utils\Sequence;

use JJWare\Utils\Option\Option;
use JJWare\Utils\TailCall\TailCall;

abstract class Sequence 
{
    public abstract function head();
    public abstract function tail();
    public abstract function take(int $n): Sequence;
    public abstract function takeWhile(callable $p): Sequence;
    public abstract function isEmpty(): bool;
    public abstract function headOption(): Option;
    public abstract function tailOption(): Option;
    public abstract function drop(int $num): Sequence;
    public abstract function dropWhile(callable $f): Sequence;
    public abstract function reverse(): Sequence;
    public abstract function length(): int;
    public abstract function foldLeft($identity, callable $f);
    public abstract function foldRight($identity, callable $f);
    public abstract function reduce(callable $f);
}