<?php

namespace App\View\Components;

use Illuminate\View\Component;

class table extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $list;
    public $columns;
    public $filters;
    public $querylink;
    public $settings;

    public function __construct($list,$columns,$filters,$querylink,$settings)
    {
        $this->list = $list;
        $this->columns = $columns;
        $this->filters = $filters;
        $this->querylink = $querylink;
        $this->settings = $settings;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.table');
    }
}
