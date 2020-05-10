<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes\examples;

function FunctionWithAttribute():void
{

}

(new TestAttribute(3, "bar"))->addToFunction("iggyvolz\\virtualattributes\\examples\\FunctionWithAttribute");