<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserLayout extends Component
{
    public ?string $title;
    public ?string $background;

    public function __construct(string $title = null, string $background = null)
    {
        $this->title = $title;
        $this->background = $background;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.user');
    }
}
