<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Livewire\Component;



class TestController extends Controller
{
    //
    public function test(){
        return view('welcome')->layout('livewire.admin.layouts.base');
        return view('welcome')->extends('livewire.admin.layouts.base');
    }
}
