<?php

namespace App\Livewire;

use Livewire\Component;

class HelloWorld extends Component
{   public $name = 'Sudhir';
    public $age = '30';
    public $address = 'Lucknow';

    public function render()
    {
        return view('livewire.hello-world')->layout('livewire.admin.layouts.base');
    }
}

