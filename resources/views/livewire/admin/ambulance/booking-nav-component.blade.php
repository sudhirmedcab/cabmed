<div class="card text-center mt-2 mb-2">
    <div class="custom__driver__filter card-header">
        <ul class="nav nav-tabs custom__nav__tab  card-header-tabs d-flex justify-content-around overflow-auto flex-nowrap">
            <li class="nav-item">
                <a class="nav-link fs-1" href="#">Dashboard</a>
            </li>
            <li class="nav-item {{ Request::is('booking') && ($this->activeTab == null) ? 'active':''}}">
                <a class="nav-link fs-1 " href="/booking" wire:navigate>All</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link">Generate</a>
            </li>
            <!-- <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1" href="/booking-calender" wire:navigate>
                    Scheduled
                </a>
            </li> -->
            <li class="nav-item {{ Request::is('driver_autosearch') || ($this->activeTab == 'driverAutosearch') ?  'active' : '' }}">
                <a class="custom__nav__btn nav-link fs-1 " href="/driver_autosearch">
                    Auto Search
                </a>
            </li>
            <li class="nav-item {{$this->activeTab == 'ConsumerEmergency' ? 'active':''}}">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('ConsumerEmergency')">
                   Consumer Emergency
                </a>
            </li>
            <li class="nav-item {{$this->activeTab == 'DriverEmergency' ? 'active':''}}">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('DriverEmergency')">
                   Driver Emergency
                </a>
            </li>
            <li class="nav-item {{$this->activeTab == 'airAmbulance' ? 'active':''}}">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('airAmbulance')">
                    Air Ambulance
                </a>
            </li>
        </ul>
    </div>
</div>