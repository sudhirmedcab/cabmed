<div class="card my-2  text-center">
  <div class="card-header custom__driver__filter">
    <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
      <li class="nav-item {{$this->activeTab == 'all' ? 'active':''}}">
        <a class="nav-link fs-1" href="/driver" wire:navigate>All </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'add' ? 'active':''}}">
        <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link">Add</a>
      </li>
      <li class="nav-item {{$this->activeTab == 'division' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('division')">
          Division
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'district' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('district')">
          District
        </a>
      </li>
      <li class="nav-item  {{$this->activeTab == 'under reg.' ? 'active':''}}">
        <a class="nav-link fs-1" href="#">Under Reg.</a>
      </li>
      <li class="nav-item {{$this->activeTab == 'walletBalance' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('walletBalance')">
          Wallet
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'Active' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Active')">
          Active
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'Onduty' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Onduty')">
          On Duty
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'Offduty' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('Offduty')">
          Off Duty
        </a>
      </li>
      <li class="nav-item {{$this->activeTab == 'UnderVerificationBySelf' ? 'active':''}}">
        <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('UnderVerificationBySelf')">
          Under Verification
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