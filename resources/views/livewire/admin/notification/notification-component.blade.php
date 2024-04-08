<div class="content">


@php 
$stateData = DB::table('state')->where('state_status','1')->get();
$cityData = DB::table('city')->where('city_status','1')->get();
@endphp

@include('livewire.admin.notification.notification_nav_bar')

@if (session()->has('inactiveMessage'))

<div class="alert alert-danger alert-dismissible" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
    <strong>{{ session('inactiveMessage') }}!</strong>
</div>

@elseif (session()->has('activeMessage'))

<div class="alert alert-success alert-dismissible" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
    <strong>{{ session('activeMessage') }}!</strong>
</div>
@endif

@if(!$this->activeTab == 'Consumer')
    <div class="card mt-2">
    <form enctype="multipart/form-data">
        <div class="card-header custom__filter__select ">
            <div class="col-12 p-0">
                <div class="form-group">
                    <label class="custom__label" for="notificationTitle">Title</label>
                    <input wire:model="notificationTitle" type="text" class="custom__input__field rounded form-control form-control-sm" id="notificationTitle" placeholder="Notification title">
                    @error('notificationTitle') <span class="text-danger">{{ $message }}</span> @enderror  
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="form-group">
                    <label class="custom__label" for="notificationBody">Body</label>
                    <textarea  wire:model="notificationBody" id="notificationBody" class="rounded form-control" placeholder="Notification Body" cols="30" rows="100"></textarea>
                    @error('notificationBody') <span class="text-danger">{{ $message }}</span> @enderror  
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="driverselectedStatus">Status</label>
                        <select wire:model="driverselectedStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driverselectedStatus">
                            <option selected value="">Choose The Status</option>
                            <option  value="1">Active</option>
                            <option value="2">Inactive</option>
                            <option value="All">All</option>
                        </select>
                        @error('driverselectedStatus') <span class="text-danger">{{ $message }}</span> @enderror  
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="driverselectedduty">Driver Duty Status</label>
                        <select  wire:model="driverselectedduty" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driverselectedduty">
                            <option selected value="">Choose Driver Duty</option>
                            <option  value="ON">On Duty</option>
                            <option value="OFF">Off Duty</option>
                            <option value="All">All</option>
                        </select>
                        @error('driverselectedduty') <span class="text-danger">{{ $message }}</span> @enderror  
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="driverselectedupdatedTime">Driver Updated Time</label>
                        <select wire:model ="driverselectedupdatedTime" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driverselectedupdatedTime">
                            <option selected value="">Choose The Driver Updated Time</option>
                            <option value="Month">Updated From 1 month</option>
                            <option value="week">Updated From 1 week</option>
                            <option value="all">All</option>
                        </select>
                        @error('driverselectedupdatedTime') <span class="text-danger">{{ $message }}</span> @enderror  

                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="driverselectedState">Select State</label>
                        <select wire:model ="driverselectedState" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driverselectedState">
                        <option selected value="">Choose State</option>     
                        @foreach($stateData as $state)
                            <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                            @endforeach
                        </select>
                        @error('driverselectedState') <span class="text-danger">{{ $message }}</span> @enderror                    
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="driverselectedCity">Select City</label>
                        <select  wire:model="driverselectedCity" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driverselectedCity">
                        <option selected value="">Choose City</option>  
                        @foreach($cityData as $city)
                            <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                            @endforeach    
                            <div wire:loading wire:target="driverselectedCity" wire:key="driverselectedCity"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i></div>                  
                        </select>
                        @error('driverselectedCity') <span class="text-danger">{{ $message }}</span> @enderror  
                    </div>
                </div>
                <div class="col-6 col-sm-2 h-100 ml-auto mt-4">
                    <button wire:click.prevent="sendNotificationDriver()" wire:loading.attr="disabled" type="submit"  class="h-100 rounded text-white form-control form-control-sm btn-primary">
                        Submit   <div wire:loading wire:target="sendNotificationDriver" wire:key="sendNotificationDriver"><i class="fa fa-spinner fa-spin"></i></div>
                    </button>
                   
                </div>

            </div>
        </div>
       </form>
    </div>
@elseif ($this->activeTab == 'Consumer')
<div class="card mt-2">
<form enctype="multipart/form-data">
        <div class="card-header custom__filter__select ">
        <div class="col-12 p-0">
                <div class="form-group">
                    <label class="custom__label" for="notificationtitle">Title</label>
                    <input wire:model="notificationtitle" type="text" id="notificationtitle" class="custom__input__field rounded form-control form-control-sm" id="notificationTitle" placeholder="Notification title">
                    @error('notificationtitle') <span class="text-danger">{{ $message }}</span> @enderror  
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="form-group">
                    <label class="custom__label" for="notificationbody">Body</label>
                    <textarea  wire:model="notificationbody" id="notificationBody" class="rounded form-control" placeholder="Notification Body" cols="30" rows="100"></textarea>
                    @error('notificationbody') <span class="text-danger">{{ $message }}</span> @enderror  
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-6">
                    <div class="form-group">
                        <label class="custom__label" for="consumerStatus">Status</label>
                        <select  wire:model="consumerStatus"  id="consumerStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm">
                            <option selected value="">Choose State</option>
                            <option  value="1">Active</option>
                            <option  value="0">New</option>
                            <option value="2">Inactive</option>
                            <option value="All">All</option>
                        </select>
                        @error('consumerStatus') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
               
              
                <div class="col-6 col-sm-6 h-100 ml-auto mt-4">
                <button wire:click.prevent="sendNotificationConsumer()" wire:loading.attr="disabled" type="submit"  class="h-100 rounded text-white form-control form-control-sm btn-primary">
                        Submit   <div wire:loading wire:target="sendNotificationConsumer" wire:key="sendNotificationConsumer"><i class="fa fa-spinner fa-spin"></i></div>
                    </button>
                </div>

            </div>
        </div>
     </form>
    </div>
@endif
</div>
