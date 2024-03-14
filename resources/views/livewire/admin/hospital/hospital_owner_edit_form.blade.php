<!-- resources/views/livewire/partner-form.blade.php -->
<!--------------- Php Data Part --------->
@php

$cityData = DB::table('city')->get();

@endphp

<!--------------- Php Data Part --------->

<!--------------- Internal Css Part --------->

<style>
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 400;
        font-size: small;
    }

    .custom-file-input,
    .custom-select,
    .form-control {
        font-size: small;
        border-radius: 4px;
    }

    #partnerModal .modal-title {
        font-size: 12px;
    }

    #partnerModal .form-control {
        height: 30px;
    }
    #partnerModal label{
        font-weight: bold;
        font-size: 10px;
        margin-bottom: .25rem;
    }
    #partnerModal input, #partnerModal select{
        font-size: 10px;
    }
</style>

<!--------------- Internal Css Part --------->


<!------------------------------------------------------- Model Form Data For Partner Data ----------------------------------------------------------------------------->

<div class="modal" id="partnerModal" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 align-items-center">
                <h5 class="modal-title w-100 text-center">{{ $this->hospital_users_id ? 'Edit Hospital Owner Data' : 'Add Hospital Owner Data' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_users_name">Name</label>
                            <input wire:model="hospital_users_name" type="text" autopcomplete="off" class="form-control" id="hospital_users_name" placeholder="Enter Facility Name">
                            @error('hospital_users_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_name">Mobile</label>
                            <input wire:model="hospital_users_mobile" type="text" autopcomplete="off" class="form-control" id="hospital_users_mobile" placeholder="Enter Facility Name">
                            @error('hospital_users_mobile') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_users_email">Email</label>
                            <input wire:model="hospital_users_email" type="text" autopcomplete="off" class="form-control" id="hospital_users_email" placeholder="Enter Facility Name">
                            @error('hospital_users_email') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>

                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_users_password">Password</label>
                            <input wire:model="hospital_users_password" type="text" autopcomplete="off" class="form-control" id="hospital_users_password" placeholder="Enter Pincode Number">
                            @error('hospital_users_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
    
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_name">Adhar Number</label>
                            <input wire:model="hospital_users_aadhar_no" type="text" autopcomplete="off" class="form-control" id="hospital_users_aadhar_no" placeholder="Enter Facility Name">
                            @error('hospital_users_aadhar_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     
                    </div>
                    <input type="hidden" wire:model="hospital_users_id">
                    <div class="row align-items-center justify-content-end">
                        <!-- <div class="col-6"><button type="button" class="submit__btn btn-danger py-2 px-3 rounded" id="btnclose" data-dismiss="modal">Close</button></div> -->
                        <div class="">
                            <button wire:click.prevent="updateHospitalOwner()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $hospital_users_id ? 'Update' : 'Submit' }}
                                <div wire:loading wire:target="updateHospitalOwner" wire:key="updateHospitalOwner()"><i class="fa fa-spinner fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
