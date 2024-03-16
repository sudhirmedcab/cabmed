<div class="card my-2  text-center">
  <div class="card-header custom__driver__filter">
    <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
      <li class="nav-item {{$this->activeTab == null ? 'active':''}}">
        <a class="nav-link fs-1" href="/lab_list" wire:navigate>Lab list</a>
      </li>
      
      <li class="nav-item {{$this->activeTab == 'facilityData' ? 'active':''}}">
        <a wire:navigate href="{{route('lab_details',['LabId' => Crypt::encrypt(1),'Details'=> 'Details'])}}" class="custom__nav__btn nav-link fs-1">
          Details
        </a>
      </li>

      <li class="nav-item  {{$this->activeTab == 'ambulanceAddOnce' ? 'active':''}}">
        <a wire:navigate href="{{route('lab_details',['LabId' => Crypt::encrypt(1),'Details'=> 'Transaction'])}}" class="custom__nav__btn nav-link fs-1">
         Transaction
        </a>
      </li>

    </ul>
  </div>
</div>