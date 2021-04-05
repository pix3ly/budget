<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SidebarTab extends Component
{
    public $icon;
    public $text;
    public $path;
    public $isCurrentPath;

    public function __construct($icon, $text, $path)
    {
        $this->icon = $icon;
        $this->text = $text;
        $this->path = $path;

        $currentPath = trim(Route::getCurrentRoute()->uri(), '/');

        $this->isCurrentPath = ltrim($this->path, '/') === $currentPath;

        // $this->text = $currentPath;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.sidebar-tab');
    }
}
