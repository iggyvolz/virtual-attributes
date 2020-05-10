<?php

namespace iggyvolz\virtualattributes\tests;

use iggyvolz\virtualattributes\examples\ClassWithAttribute;
use iggyvolz\virtualattributes\examples\TestAttribute;
use iggyvolz\virtualattributes\examples\TestAttribute2;
use iggyvolz\virtualattributes\ReflectionAttribute;
use iggyvolz\virtualattributes\VirtualAttribute;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;

require_once __DIR__ . "/../examples/FunctionWithAttribute.php";

class VirtualAttributeTest extends TestCase
{
    public function setUp(): void
    {
        VirtualAttribute::$attributeDeprecations = false;
        parent::setUp();
    }

    public function testGettingAttributesFromClass():void
    {
        $attributes = VirtualAttribute::getAttributes(new ReflectionClass(ClassWithAttribute::class));
        $this->assertList(1, $attributes);
        $reflectionAttribute = $attributes[0];
        $this->assertInstanceOf(ReflectionAttribute::class, $reflectionAttribute);
        $attribute = $reflectionAttribute->newInstance();
        $this->assertInstanceOf(TestAttribute::class, $attribute);
        $this->assertSame(2, $attribute->a);
        $this->assertSame("foo", $attribute->b);
    }
    public function testGettingAttributesFromFunction():void
    {
        $attributes = VirtualAttribute::getAttributes(new ReflectionFunction("iggyvolz\\virtualattributes\\examples\\FunctionWithAttribute"));
        $this->assertList(1, $attributes);
        $reflectionAttribute = $attributes[0];
        $this->assertInstanceOf(ReflectionAttribute::class, $reflectionAttribute);
        $attribute = $reflectionAttribute->newInstance();
        $this->assertInstanceOf(TestAttribute::class, $attribute);
        $this->assertSame(3, $attribute->a);
        $this->assertSame("bar", $attribute->b);
    }
    public function testGettingAttributesFromMethod():void
    {
        $attributes = VirtualAttribute::getAttributes(new ReflectionMethod(ClassWithAttribute::class, "MethodWithAttribute"));
        $this->assertList(1, $attributes);
        $reflectionAttribute = $attributes[0];
        $this->assertInstanceOf(ReflectionAttribute::class, $reflectionAttribute);
        $attribute = $reflectionAttribute->newInstance();
        $this->assertInstanceOf(TestAttribute::class, $attribute);
        $this->assertSame(4, $attribute->a);
        $this->assertSame("bak", $attribute->b);
    }
    public function testGettingAttributesFromProperties():void
    {
        $attributes = VirtualAttribute::getAttributes(new ReflectionProperty(ClassWithAttribute::class, "propertyWithAttribute"));
        $this->assertList(1, $attributes);
        $reflectionAttribute = $attributes[0];
        $this->assertInstanceOf(ReflectionAttribute::class, $reflectionAttribute);
        $attribute = $reflectionAttribute->newInstance();
        $this->assertInstanceOf(TestAttribute::class, $attribute);
        $this->assertSame(5, $attribute->a);
        $this->assertSame("bin", $attribute->b);
    }
    public function testGettingAttributesFromClassConstants():void
    {
        $attributes = VirtualAttribute::getAttributes(new ReflectionClassConstant(ClassWithAttribute::class, "CLASS_CONSTANT_WITH_ATTRIBUTE"));
        $this->assertList(1, $attributes);
        $reflectionAttribute = $attributes[0];
        $this->assertInstanceOf(ReflectionAttribute::class, $reflectionAttribute);
        $attribute = $reflectionAttribute->newInstance();
        $this->assertInstanceOf(TestAttribute::class, $attribute);
        $this->assertSame(6, $attribute->a);
        $this->assertSame("ying", $attribute->b);
    }
    public function testGetMultipleAttributes():void
    {
        $attributes = VirtualAttribute::getAttributes(new ReflectionMethod(ClassWithAttribute::class, "MethodWithMultipleAttributes"));
        $this->assertList(3, $attributes);
        // Test attribute types
        foreach([TestAttribute::class, TestAttribute::class, TestAttribute2::class] as $i => $class) {
            $this->assertInstanceOf($class, $attributes[$i]->newInstance());
        }
        foreach($attributes as $i => $reflectionAttribute) {
            $this->assertInstanceOf(ReflectionAttribute::class, $reflectionAttribute);
            $attribute = $reflectionAttribute->newInstance();
            $this->assertInstanceOf(VirtualAttribute::class, $attribute);
            // Assert that no two attributes are equal
            for($j=0; $j<$i; $j++) {
                $otherAttribute = $attributes[$j]->newInstance();
                $this->assertNotSame($attribute, $otherAttribute);
            }
        }
    }

    public function testDeprecationError():void
    {
        VirtualAttribute::$attributeDeprecations = true;
        $this->expectDeprecation();
        $this->expectDeprecationMessage("Use Attributes in PHP 8: use <<iggyvolz\\virtualattributes\\examples\\TestAttribute(7, 'yak')>>");
        new TestAttribute(7, "yak");
    }

    private function assertList(int $length, $arr):void
    {
        $this->assertIsArray($arr);
        if($length === 0) {
            $this->assertEmpty($length);
        } elseif($length < 0) {
            throw new \LogicException("List cannot be of negative length");
        } else {
            $this->assertSame(range(0,$length-1), array_keys($arr));
        }
    }
}
