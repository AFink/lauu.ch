<?php

namespace App\View\Components;

use App\Models\Shortlink;
use Illuminate\View\Component;

class Disclaimer extends Component
{

    public $shortlink;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Shortlink $shortlink)
    {
        $this->shortlink = $shortlink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.disclaimer');
    }
}