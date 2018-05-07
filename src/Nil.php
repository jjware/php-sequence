<?php

namespace JJWare\Utils\Sequence;

use JJWare\Utils\Option\Option;

class Nil extends Sequence
{
    public function head()
    {
        throw new \BadMethodCallException("attempt to access head of empty sequence");
    }

    public function tail(): Sequence
    {
        throw new \BadMethodCallException("attempt to access tail of empty sequenece");
    }

    public function isEmpty(): bool
    {
        return true;
    }

    public function take(int $n): Sequence
    {
        throw new \BadMethodCallException("take called on an empty sequenece");
    }

    public function takeWhile(callable $p): Sequence
    {
        return $this;
    }

    public function headOption(): Option
    {
        return Option::none();
    }

    public function tailOption(): Option
    {
        return Option::none();
    }

    public function drop(int $n): Sequence
    {
        return $this;
    }

    public function dropWhile(callable $p): Sequence
    {
        return $this;
    }

    public function reverse(): Sequenece
    {
        return $this;
    }

    public function foldLeft($acc, callable $f)
    {
        return $acc;
    }

    public function foldRight($acc, callable $f)
    {
        return $acc;
    }

    public function reduce(callable $f)
    {
        throw new \BadMethodCallException("cannot reduce an empty sequence without a zero");
    }

    public function length(): int
    {
        return 0;
    }
}