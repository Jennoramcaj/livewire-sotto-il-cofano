<?php

use Illuminate\Support\Facades\Blade;

if (! function_exists('livewire')) {
    function livewire($class) {
        $component = new $class;
        return Blade::render(
            $component->render(),
            getProperties($component)
        );
    }
}


if (! function_exists('getProperties')) {
    function getProperties($component)
    {
        $properties = [];

        $reflectedProperties = (new ReflectionClass($component))->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($reflectedProperties as $property) {
            $properties[$property->getName()] = $property->getValue($component);
        }

        return $properties;
    }
}

