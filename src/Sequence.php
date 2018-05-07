<?php

namespace JJWare\Utils\Sequence;

use JJWare\Utils\Option\Option;
use JJWare\Utils\TailCall\TailCall;

abstract class Sequence 
{
    private static $n = null;

    public static function nil(): Nil
    {
        if (is_null(self::$n)) {
            self::$n = new Nil();
        }
        return self::$n;
    }

    public static function cons($h, Sequence $t)
    {
        return new Cons($h, $t);
    }

    public static function foldR(Sequence $s, $n, callable $f) {
        return $s->foldRight($n, $f);
    }

    public static function concat(Sequence $s1, Sequence $s2): Sequence
    {
        return self::foldR($s1, $s2, function ($x) {
            return function ($y) use ($x) {
                return self::cons($x, $y);
            };
        });
    }

    public static function flatten(Sequence $s): Sequence
    {
        return self::foldR($s, self::nil(), function ($x) {
            return function ($y) use ($x) {
                return self::concat($x, $y);
            };
        });
    }

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

    public function prepend($value): Sequence
    {
        return self::cons($value, $this);
    }

    public function map(callable $f): Sequence
    {
        return foldRight(self::nil(), function ($h) use ($f) {
            return function ($t) use ($h, $f) {
                return self::cons(call_user_func($f, $h), $t);
            };
        });
    }

    public function filter(callable $p): Sequence
    {
        return foldRight(self::nil(), function ($h) use ($p) {
            return function ($t) use ($h, $p) {
                return call_user_func($p, $h) ? self::cons($h, $t) : $t;
            };
        });
    }

    public function flatMap(callable $f): Sequence
    {
        return foldRight(self::nil(), function ($h) use ($f) {
            return function ($t) use ($f, $h) {
                return self::concat(call_user_func($f, $h), $t);
            };
        });
    }

    public function forEach(callable $f)
    {
        for ($xs = $this; !$xs->isEmpty(); $xs = $xs->tail()) {
            call_user_func($f, $xs->head());
        }
    }
}