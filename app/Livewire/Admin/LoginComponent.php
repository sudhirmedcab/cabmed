<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class LoginComponent extends Component
{
    public function render()
    {
        // dd('hj');
        // return view('livewire.admin.login-component');
        return view('livewire.admin.login-component')->layout('livewire.admin.login-component');
        // return view('livewire.admin.login-component')->layout('livewire.admin.layouts.base');
    }
}
