<?php

namespace App\Livewire;

class Counter
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function render(): string
    {
        return <<<'HTML'
    <div class="flex items-center justify-center h-screen text-4xl space-x-6">
        <span>Conteggio: </span>
        <div>
            <span class="font-semibold">{{ $count }}</span>
            <button wire:click="increment"> + </button>
            <input type="text">
        </div>
    </div>
HTML;
    }
}
