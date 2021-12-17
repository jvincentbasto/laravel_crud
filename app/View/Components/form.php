<?php

namespace App\View\Components;

use Illuminate\View\Component;

class form extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form');
    }
}
