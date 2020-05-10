<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes\examples;

use iggyvolz\virtualattributes\VirtualAttribute;

class TestAttribute2 extends VirtualAttribute
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