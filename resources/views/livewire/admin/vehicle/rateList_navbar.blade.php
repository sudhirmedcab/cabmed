<div class="card my-2  text-center">
  <div class="card-header custom__driver__filter">
    <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
      <li class="nav-item {{$this->activeTab == null ? 'active':''}}">
        <a class="nav-link fs-1" href="/rateList" wire:navigate>Ambulance list</a>
      </li>
      
      <li class="nav-item {{$this->activeTab == 'facilityData' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('facilityData')">
         Ambulance Facility
        </a>
      </li>

      <li class="nav-item  {{$this->activeTab == 'ambulanceAddOnce' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('ambulanceAddOnce')">
        Ambulance Add On's
        </a>
      </li>

    </ul>
  </div>
</div>