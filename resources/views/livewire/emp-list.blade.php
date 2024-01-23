<div class="content">
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

            
            <div class="card">
           
              <div class="card-header">
                <h3 class="card-title"
                <button wire:click="create()" class="mb-2 btn btn-sm btn-primary">Create Employee</button>
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
                <table class="table table-sm">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Employee code</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->employee_id }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>
                            <button wire:click="edit({{ $employee->id }})" class="btn btn-sm btn-primary">Edit</button>
                            <button wire:confirm="Are you sure you want to delete this post?"
                                wire:click="delete({{ $employee->id }})" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            </div>
            </div>
          
          <div class="card-footer clearfix">
                        {!! $employees->links() !!}
            </div>
            
    </div>
    </div>
</div>



