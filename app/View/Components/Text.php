<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Text extends Component
{
    public $id;
    public $value;
    public $label;
    public $name;
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $value, $name, $type='text')
    {
        $this->name = $name;
        $this->id = Str::random(10);
        $this->value = $value;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.text');
    }
}
