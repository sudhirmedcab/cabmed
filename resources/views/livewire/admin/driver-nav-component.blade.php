<div class="card text-center">
          <div class="card-header pt-1 pb-3">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
              <li class="nav-item">
                <a class="nav-link fs-1 active" href="/driver" wire:navigate >All </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link" >Add</a>
              </li>
              <li class="nav-item">
                <!-- <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'division' ? 'btn-primary':''}}" href="driver/division" wire:navigate> -->
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'division' ? 'btn-primary':''}}"  wire:click="filterCondition('division')">
                Division
              </a>
              </li>
              <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'district' ? 'btn-primary':''}}"  wire:click="filterCondition('district')">
                District  
              </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Under Reg.</a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'walletBalance' ? 'btn-primary':''}}" wire:click="filterCondition('walletBalance')">
               Wallet
              </a>
              </li>
              <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'Active' ? 'btn-primary':''}}" wire:click="filterCondition('Active')">
                  Active
                </a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'Onduty' ? 'btn-primary':''}}" wire:click="filterCondition('Onduty')">
                  On Duty
              </a>
              </li>
              <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'Offduty' ? 'btn-primary':''}}" wire:click="filterCondition('Offduty')">
                Off Duty
                </a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'UnderVerificationBySelf' ? 'btn-primary':''}}" wire:click="filterCondition('UnderVerificationBySelf')">
              Under Verification
              </a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'documentExpiry' ? 'btn-primary':''}}" wire:click="filterCondition('documentExpiry')">
              Document Expiry
              </a>
              </li>

            </ul>
          </div>
         </div>