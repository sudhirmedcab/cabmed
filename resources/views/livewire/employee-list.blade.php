<div>
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <button wire:click="create()" class="btn btn-primary">Create Employee</button>

    @if($isOpen)
        @include('livewire.employee-form')
    @endif

    <table class="table table-bordered mt-5">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Action</th>
        </tr>
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->id }}</td>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->position }}</td>
            <td>
                <button wire:click="edit({{ $employee->id }})" class="btn btn-primary">Edit</button>
                <button wire:click="delete({{ $employee->id }})" class="btn btn-danger">Delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
