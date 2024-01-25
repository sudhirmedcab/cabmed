<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\EmployeeList;
// use App\Http\Livewire\EmpList;
use App\Livewire\EmpList;
use App\Livewire\HelloWorld;
use App\Livewire\HomeComponent;
use App\Livewire\Admin\LoginComponent;
use App\Livewire\Admin\DriverComponent;
use App\Livewire\Admin\ManageDriverComponent;

use App\Http\Controllers\TestController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    // Route::get('/', function () {
    //     return view('welcome');
    // });
    // Route::view('emp', 'empManagement');
    // Route::view('emplist', 'empData');

    Route::get('/', HomeComponent::class)->name('app.home');
  

    // Route::group(['middleware' => 'admin.auth'], function () {
    //     // Your admin-only routes go here
    //     Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    //     Route::get('/emplist', EmpList::class);
    //     Route::get('/page1', HomeComponent::class);
    //     Route::get('/booking', HelloWorld::class);
    // });
     
    Route::get('/', LoginComponent::class);

    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/emplist', EmpList::class);
    Route::get('/page1', HomeComponent::class);
    Route::get('/booking', HelloWorld::class);
    Route::get('/login', LoginComponent::class);
    Route::get('/driver', DriverComponent::class);
    Route::get('/manage-driver', ManageDriverComponent::class);

