<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes\examples;

// <<TestAttribute(2, "foo")>>
class ClassWithAttribute
{
    // <<TestAttribute(6, "ying")>>
    public const CLASS_CONSTANT_WITH_ATTRIBUTE=12345;
    // <<TestAttribute(5, "bin")>>
    public int $propertyWithAttribute;
    // <<TestAttribute(4, "bak")>>
    public function MethodWithAttribute():void
    {

    }
    // <<TestAttribute(7, "yang")>>
    // <<TestAttribute(8, "yeet")>>
    // <<TestAttribute2(9, "yoink")>>
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