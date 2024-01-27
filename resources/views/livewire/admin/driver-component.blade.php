<div class="content" wire:init="livewire.admin.DriverComponent">
    <div class="container-fluid">
        @if ($isOpen)
            @include('livewire.employee-form')
        @endif
        @if (session()->has('message') && session()->has('type') == 'delete')
            <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
         {{ $search }}
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
                <a class="nav-link fs-1" href="#">Devision</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">District</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Under Reg.</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Under FRC</a>
              </li><li class="nav-item">
                <a class="nav-link fs-1" href="#">Active</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">On Duty</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Off Duty</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Verify By driver</a>
              </li>

              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Verify By Partner</a>
              </li>
            </ul>
          </div>
        
        </div>
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                <button wire:click="create()" class="mb-2 btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                </h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="search" wire:model.live.debounce.150ms="search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
                <div class="card-body p-0">
                <table class="table custom__table table-bordered table-sm">
                <tr>
                    <th>Driver Id</th>
                    <th>Name</th>
                    <th>Created Date</th>
                    <th>Created By</th>
                    <th>Driver Status</th>
                    <!-- <th>Remark Details</th> -->
                    <th>City</th>
                    <th>RC No.</th>
                    <!-- <th>DL No.</th> -->
                    <th>Action</th>
                </tr>
                @foreach ($drivers as $driver)
                    <tr>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ $driver->driver_name.' '.$driver->driver_last_name }}</td>
                        <td>{{ $driver->created_at }}</td>
                        <td>
                        @if($driver->driver_created_by=='0')
												 Self Created
												 @else
												 Partner Created
                        @endif
                        </td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <!-- <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td> -->
                        <td class="action__btn lbtn-group">
                            <button wire:click="edit({{ $driver->driver_id }})" class="pt-0 pl-2 pr-2 pb-1 btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                            <button wire:confirm="Are you sure you want to delete this post?"
                                wire:click="delete({{ $driver->driver_id }})" class="pt-0 pl-2 pr-2 pb-1 btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </table>
            </div>
            </div>
          
          <div class="custom__pagination card-footer__ clearfix">
                        {!! $drivers->links() !!}
            </div>
            
    </div>
    </div>
</div>



