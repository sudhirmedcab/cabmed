<!-- resources/views/livewire/employee-form.blade.php -->

<div class="modal" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $employee_id ? 'Edit Employee' : 'Create Employee' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input wire:model="name" type="text" class="form-control" id="name" placeholder="Enter Name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input wire:model="email" type="text" class="form-control" id="email" placeholder="Enter Email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="employee_id">Employee Code</label>
                        <input wire:model="employee_id" type="text" class="form-control" id="employee_id" placeholder="Enter Employee Id">
                        @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input wire:model="position" type="text" class="form-control" id="position" placeholder="Enter Position">
                        @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <input type="hidden" wire:model="id">
                    <button wire:click.prevent="store()" class="mt-2 btn btn-primary">{{ $id ? 'Update' : 'Save' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
