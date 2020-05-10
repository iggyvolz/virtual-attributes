<?php

declare(strict_types=1);

namespace iggyvolz\virtualattributes;

class ReflectionAttribute
{
    private VirtualAttribute $object;
    private array $args;

    public function __construct(VirtualAttribute $attribute, array $args)
    {
        $this->object = $attribute;
        $this->args = $args;
    }
    public function getName(): string
    {
        return get_class($this->object);
    }
    public function getArguments(): array
    {
        return $this->args;
    }
    public function newInstance(): object
    {
        return $this->object;
    }
}