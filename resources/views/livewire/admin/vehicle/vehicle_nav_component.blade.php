<div class="card my-2  text-center">
  <div class="card-header custom__driver__filter">
    <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
      <li class="nav-item {{$this->activeTab == null ? 'active':''}}">
        <a class="nav-link fs-1" href="/vehicle_details" wire:navigate>Vehicle list</a>
      </li>
      <li class="nav-item {{$this->activeTab == 'addVehicle' ? 'active':''}}">
        <a class="nav-link fs-1" href="{{route('add-vehicle',['vehicleId' => Crypt::encrypt(null)])}}" wire:navigate class="nav-link" wire:click="filterCondition('addVehicle')">Add</a>
      </li>
      <li class="nav-item {{$this->activeTab == 'cityCount' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('cityCount')">
          City Counts
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'districtCount' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('districtCount')">
          District counts
        </a>
      </li>
      <li class="nav-item  {{$this->activeTab == 'districtWise' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('districtWise')">
          District Wise
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'divisionWise' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('divisionWise')">
          Division Wise
        </a>
      </li>
     
      <li class="nav-item {{$this->activeTab == 'totalData' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('totalData')">
          Total Data
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'bookingVehicle' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('bookingVehicle')">
          Booking Vehicle
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'cityWiseBooking' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('cityWiseBooking')">
          City Wise Booking
        </a>
      </li>
      
      <li class="nav-item {{$this->activeTab == 'documentExpiry' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('documentExpiry')">
          Document Expiry
        </a>
      </li>

    </ul>
  </div>
</div>