<?php

declare(strict_types=1);

namespace App\Components;

use Confetti\Parser\Components\Map;

abstract class RootComponent extends Map
{
    public function type(): string
    {
        return 'root';
    }

    /**
     * The Label is used as a title for the menu in the admin panel
     */
    public function label(string $label): self
    {
        return $this;
    }

    public function __get(string $name): void
    {
        throw new \RuntimeException("Model ->{$name}(...) not found. Create a model with `->...('{$name}')`");
    }
}
