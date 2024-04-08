<div class="card text-center mt-2 mb-2">
        <div class="custom__driver__filter card-header">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs d-flex justify-content-around overflow-auto flex-nowrap">
               <li class="nav-item {{$this->activeTab == null ? 'active':''}}">
                  <a class="nav-link fs-1" href="/notification" wire:navigate>Driver</a>
              </li>
                <li class="nav-item {{$this->activeTab == 'Consumer' ? 'active':''}}">
                     <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Consumer')">Consumer</a>
                </li>
            </ul>
        </div>
    </div>