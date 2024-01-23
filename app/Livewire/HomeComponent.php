<?php

namespace App\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        return view('livewire.home-component')->layout('livewire.admin.layouts.base');
        // below is for the $slot replacement with traditional extend
        // return view('livewire.home-component')->extends('livewire.admin.layouts.base');

    }
}
