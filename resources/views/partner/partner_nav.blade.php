<style>
a.nav-link.fs-1 {
    font-size: 12px;
    border: none;
}
</style>

<div class="card text-center">
          <div class="card-header pt-1 pb-3">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
            <li class="nav-item">
              <a wire:click="create()" class="ml-4  btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
              </li>
              <li class="nav-item">
                <a href="/all-partner" wire:navigate.hover class="nav-link fs-1 no-border">All Partner </a>
              </li>
              
              <li class="nav-item">
              <a  class="nav-link fs-1 no-border" wire:click="showNested(0)">New Partner</a>
                </li>
              <li class="nav-item">
              <a wire:click="showNested(1)" class="nav-link fs-1 no-border">Active Partner</a>
              </li>
           
            </ul>
          </div>
        
        </div>