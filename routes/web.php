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
use App\Livewire\Admin\ConsumerComponent;

use App\Livewire\Admin\PartnerComponent;
use App\Livewire\Admin\RoadAmbulanceComponent;
use App\Livewire\Admin\DriverDetailComponent;
use App\Livewire\Admin\Ambulance\AmbulanceBookingComponent;
use App\Livewire\Admin\ConsumerEnquiryComponent;
use App\Livewire\Admin\ConsumerDialComponent;
use App\Livewire\Admin\ConsumerWebComponent;
use App\Livewire\Admin\DriverDetailsBookingComponent;
use App\Livewire\Admin\PartnerDetailComponent;
use App\Livewire\Admin\PartnerDetailListComponent;



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

    Route::get('/', LoginComponent::class);

    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/emplist', EmpList::class);
    Route::get('/page1', HomeComponent::class);
    Route::get('/booking', AmbulanceBookingComponent::class);
    Route::get('/login', LoginComponent::class);
    Route::get('/driver', DriverComponent::class);
    Route::get('/manage-driver', ManageDriverComponent::class);


    ## ............... Sukhi Routes for the Componet ...................##

    Route::get('/all-partner', PartnerComponent::class);
    Route::get('/roadAmbulance', RoadAmbulanceComponent::class);
    Route::get('/consumer', ConsumerComponent::class);
    Route::get('/consumer-enquiry', ConsumerEnquiryComponent::class);
    Route::get('/driver-booking-details/{driverId}/{booking_status}', DriverDetailsBookingComponent::class)->name('admin.driver-booking-component');
    Route::get('/driver-detail/{driverId}', DriverDetailComponent::class)->name('admin.driver-details-component');
    Route::get('/partner-detail/{partnerId}', PartnerDetailComponent::class)->name('partner-details-component');
    Route::get('/partner-details/{partnerId}/{detailList}', PartnerDetailListComponent::class)->name('partner-details-list-component');

