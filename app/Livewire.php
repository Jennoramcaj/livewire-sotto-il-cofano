<?php

namespace App;

use Illuminate\Support\Facades\Blade;

class Livewire
{
    public function initialRender($class): string
    {
        $component = new $class;

        $html = Blade::render(
            $component->render(),
            $properties = $this->getProperties($component)
        );

        $snapshot = [
            'class' => get_class($component),
            'data' => $properties
        ];

        // You can also use:
        // [$html, $snapshot] = $this->toSnapshot($component);

        $snapshotAttribute = htmlentities(json_encode($snapshot));

        return <<<HTML
            <div wire:snapshot="{$snapshotAttribute}">
                {$html}
            </div>
HTML;
    }

    public function getProperties($component): array
    {
        $properties = [];

        $reflectedProperties = (new \ReflectionClass($component))->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($reflectedProperties as $property) {
            $properties[$property->getName()] = $property->getValue($component);
        }

        return $properties;
    }


    public function fromSnapshot($snapshot)
    {
        $class = $snapshot['class'];
        $data = $snapshot['data'];

        $component = new $class;

        $this->setProperties($component, $data);

        return $component;
    }

    public function setProperties($component, $properties)
    {
        foreach ($properties as $key => $value) {
            $component->{$key} = $value;
        }
    }

    public function callMethod($component, $method)
    {
        $component->$method();
    }

    public function toSnapshot($component): array
    {
        $html = Blade::render(
            $component->render(),
            $this->getProperties($component)
        );

        $snapshot = [
            'class' => get_class($component),
            'data' => $this->getProperties($component)
        ];

        return [$html, $snapshot];
    }

}
