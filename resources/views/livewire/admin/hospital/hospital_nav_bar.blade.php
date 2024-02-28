<div class="card my-2  text-center">
  <div class="card-header custom__driver__filter">
    <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
      <li class="nav-item {{ Request::is('hospital_list') && ($this->activeTab == null) ? 'active':''}}">
        <a class="nav-link fs-1" href="/hospital_list" wire:navigate>Hospital List</a>
      </li>
  
    
      <li class="nav-item {{$this->activeTab == 'HospitalOwner' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('HospitalOwner')">
          Hospital Owner
        </a>
      </li>
      <li class="nav-item  {{$this->activeTab == 'districtWise' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('districtWise')">
          District Wise
        </a>
      </li>
  
      <li class="nav-item {{$this->activeTab == 'divisionWise' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('divisionWise')">
          Division Wise
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'cityWise' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('cityWise')">
          City Wise 
        </a>
      </li>
      
      <!-- <li class="nav-item {{ Request::is('hospital_map') || ($this->activeTab == 'hospitalMap') ?  'active' : '' }}">
        <a class="custom__nav__btn nav-link fs-1"   href="/hospital_map">
        Hospital In Map
        </a>
      </li> -->

    </ul>
  </div>
</div>