<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Nav extends Component
{
    public $items;
    public $active;

    public function __construct($context = 'side')
    {
        $this->items = $this->prepareItems(config('nav'));
        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav');
    }

    protected function prepareItems($items)
    {
        $user = Auth::user();
        
        foreach ($items as $key => $item){
            if (isset($item['ability']) && !$user->can($item['ability'])){
                unset($items[$key]);
            }
        }
        return $items;
    }
}
