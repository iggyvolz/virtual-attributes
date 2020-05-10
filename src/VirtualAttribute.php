<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes;

use ReflectionClass;
use ReflectionClassConstant;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Reflector;

class VirtualAttribute
{
    public static bool $attributeDeprecations = false;
    private array $args;
    public function __construct(...$args)
    {
        $this->args = $args;
        if(self::$attributeDeprecations)
        {
            $desiredString = "<<" . static::class;
            if(!empty($args)) {
                $desiredString .= "(";
                $first = true;
                foreach($args as $arg) {
                    if($first) {
                        $first = false;
                    } else {
                        $desiredString .= ", ";
                    }
                    $desiredString .= var_export($arg, true);
                }
                $desiredString .= ")";
            }
            $desiredString .= ">>";
            trigger_error("Use Attributes in PHP 8: use $desiredString", E_USER_DEPRECATED);
        }
    }

    private static array $attributes=[];

    public function addTo(Reflector $reflector):void
    {
        $id = self::getReflectorID($reflector);
        if(!array_key_exists($id, self::$attributes)) {
            self::$attributes[$id] = [];
        }
        self::$attributes[$id][] = new ReflectionAttribute($this, $this->args);
    }

    /**
     * @return ReflectionAttribute[]
     */
    public static function getAttributes(Reflector $reflector, string $class = null, int $flags=0):array
    {
        $attributes = self::$attributes[self::getReflectorID($reflector)] ?? [];
        if(is_null($class)) {
            return $attributes;
        } elseif($flags & ReflectionAttribute::IS_INSTANCEOF) {
            return array_values(array_filter($attributes, fn(ReflectionAttribute $self):bool => ($self->newInstance()) instanceof $class));
        } else {
            return array_values(array_filter($attributes, fn(ReflectionAttribute $self):bool => $self->getName() === $class));
        }
    }

    public static function getReflectorID(Reflector $reflector):string
    {
        switch(get_class($reflector)) {
            case ReflectionProperty::class:
                return "property:" . $reflector->getDeclaringClass()->getName().":".$reflector->getName();
            case ReflectionMethod::class:
                return "method:" . $reflector->getDeclaringClass()->getName().":".$reflector->getName();
            case ReflectionClassConstant::class:
                return "classconstant:" . $reflector->getDeclaringClass()->getName().":".$reflector->getName();
            case ReflectionFunction::class:
                return "function:" . $reflector->getName();
            case ReflectionClass::class:
                return "class:" . $reflector->getName();
            default:
                throw new \LogicException("Cannot add attribute to a " . get_class($reflector));
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function addToClass(string $class):void
    {
        $this->AddTo(new ReflectionClass($class));
    }

    /**
     * @throws \ReflectionException
     */
    public function addToFunction(string $function):void
    {
        $this->AddTo(new ReflectionFunction($function));
    }

    /**
     * @throws \ReflectionException
     */
    public function addToMethod(string $class, string $method):void
    {
        $this->AddTo(new ReflectionMethod($class, $method));
    }

    /**
     * @throws \ReflectionException
     */
    public function addToProperty(string $class, string $property):void
    {
        $this->AddTo(new ReflectionProperty($class, $property));
    }

    /**
     * @throws \ReflectionException
     */
    public function addToClassConstant(string $class, string $constant):void
    {
        $this->AddTo(new ReflectionClassConstant($class, $constant));
    }
}