
<div class="card text-center mt-2 mb-2">
          <div class="custom__driver__filter card-header">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs d-flex justify-content-around overflow-auto flex-nowrap">
            
                <li class="nav-item {{  (Request::is('transaction')) ? 'active':''}}">
                    <a class="custom__nav__btn nav-link fs-1" href="/transaction" wire:navigate>
                    Booking Payments
                    </a>
                </li>
                <li  class="nav-item {{$this->activeTab == 'consumerTransaction' ? 'active':''}}">
                    <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('consumerTransaction')">
                    Consumer Payments
                    </a>
                </li>
                <li  class="nav-item {{$this->activeTab == 'driverTransaction' ? 'active':''}}">
                    <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driverTransaction')">
                    Driver Payments
                    </a>
                </li>
                <li  class="nav-item {{$this->activeTab == 'driverWithdrawTransaction' ? 'active':''}}">
                    <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driverWithdrawTransaction')">
                    Driver Withdraw History
                    </a>
                </li>
                <li  class="nav-item {{$this->activeTab == 'partnerTransaction' ? 'active':''}}">
                    <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partnerTransaction')">
                    Partner Payments
                    </a>
                </li>
                <!-- <li  class="nav-item {{$this->activeTab == 'labTransaction' ? 'active':''}}">
                    <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('labTransaction')">
                    Lab Payments
                    </a>
                </li> -->
            
            </ul>
        </div>
    </div>