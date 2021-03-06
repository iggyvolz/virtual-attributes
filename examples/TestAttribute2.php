<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes\examples;

class TestAttribute2 extends TestAbstractAttribute
{
    public int $a;
    public string $b;

    public function __construct(int $a, string $b)
    {
        $this->a = $a;
        $this->b = $b;
        parent::__construct($a, $b);
    }
}