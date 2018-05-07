<?php

namespace JJWare\Utils\Sequence;

use JJWare\Utils\Option\Option;
use JJWare\Utils\TailCall\TailCall;

class Cons extends Sequence
{
    private $h;
    private $t;
    private $l;

    public function __construct($h, Sequence $t)
    {
        $this->h = $h;
        $this->t = $t;
        $this->l = $t->length() + 1;
    }

    public function head()
    {
        return $this->h;
    }

    public function tail()
    {
        return $this->t;
    }

    public function take(int $n): Sequence
    {
        return $this->isEmpty()
            ? $this
            : $n > 0
                ? new Cons($this->head(), $this->tail()->take($n -  1))
                : Nil::instance;
    }

    public function takeWhile(callable $p): Sequence
    {
        return $this->isEmpty()
            ? $this
            : call_user_func($p, $this->head())
                ? new Cons($this->head(), $this->tail()->takeWhile($p))
                : Nil::instance;
    }

    public function isEmpty(): bool
    {
        return false;
    }

    public function headOption(): Option
    {
        return Option::some($this->h);
    }

    public function tailOption(): Option
    {
        return Option::some($this->t);
    }

    private static function drop_(Sequence $s, int $n): TailCall
    {
        return $n <= 0 || s.isEmpty()
            ? TailCall::ret($s)
            : TailCall::sus(function () use ($s, $n) {
                return self::drop_($s->tail(), $n - 1);
            });
    }

    public function drop(int $n): Sequence
    {
        return $n <= 0
            ? $this
            : $this->drop_($this, $n)->eval();
    }

    private static function dropWhile_(Sequence $s, callable $p): TailCall
    {
        return !$s.isEmpty() && call_user_func($p, $s->head())
            ? TailCall::sus(function () use ($s, $p) {
                return self::dropWhile_($s->tail(), $p);
            })
            : TailCall::ret($s);
    }

    public function dropWhile(callable $p): Sequence
    {
        return self::dropWhile_($this, $p)->eval();
    }

    private static function reverse_(Sequence $acc, Sequence $s): TailCall
    {
        return $s->isEmpty()
            ? TailCall::ret($acc)
            : TailCall::sus(function () use ($acc, $s) {
                return self::reverse_(new Cons($s->head(), $acc), $s->tail());
            });
    }

    public function reverse(): Sequence
    {
        return self::reverse_(Nil::instance, $this)->eval();
    }

    private static function foldLeft_($acc, Sequence $s, callable $f): TailCall
    {
        return $s->isEmpty()
            ? TailCall::ret($acc)
            : TailCall::sus(function () use ($acc, $s, $f) {
                return self::foldLeft_(call_user_func(call_user_func($f, $acc), $s->head()), $s->tail(), $f);
            });
    }

    public function foldLeft($acc, callable $f)
    {
        return self::foldLeft_($acc, $this, $f)->eval();
    }

    public function foldRight($acc, callable $f)
    {
        return $this->reverse()->foldLeft($this->head(), $f);
    }

    public function reduce(callable $f)
    {
        return $this->tail()->foldLeft($this->head(), $f);
    }

    public function length(): int
    {
        return $this->l;
    }
}