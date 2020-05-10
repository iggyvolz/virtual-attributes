<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes\examples;

class ClassWithAttribute
{
    public const CLASS_CONSTANT_WITH_ATTRIBUTE=12345;
    public int $propertyWithAttribute;
    public function MethodWithAttribute():void
    {

    }
    public function MethodWithMultipleAttributes():void
    {

    }
}

(new TestAttribute(2, "foo"))->addToClass(ClassWithAttribute::class);
(new TestAttribute(4, "bak"))->addToMethod(ClassWithAttribute::class, "MethodWithAttribute");
(new TestAttribute(5, "bin"))->addToProperty(ClassWithAttribute::class, "propertyWithAttribute");
(new TestAttribute(6, "ying"))->addToClassConstant(ClassWithAttribute::class, "CLASS_CONSTANT_WITH_ATTRIBUTE");
(new TestAttribute(7, "yang"))->addToMethod(ClassWithAttribute::class, "MethodWithMultipleAttributes");
(new TestAttribute(8, "yeet"))->addToMethod(ClassWithAttribute::class, "MethodWithMultipleAttributes");
(new TestAttribute2(9, "yoink"))->addToMethod(ClassWithAttribute::class, "MethodWithMultipleAttributes");