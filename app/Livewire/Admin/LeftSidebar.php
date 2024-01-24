<?php

namespace App\Livewire\Admin;
use Session;
use Livewire\Component;

class LeftSidebar extends Component
{
    public function render()
    {
        return view('livewire.admin.left-sidebar');
    }

    public function logout()
    {
        Session::flush();
        
        return redirect()->to('/login')->with('success','Your Have Logout');
    }
}
