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
                <h5 class="modal-title w-100 text-center">{{ $this->hospital_id ? 'Edit Hospital Data' : 'Add Hospital Data' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_name">Name</label>
                            <input wire:model="hospital_name" type="text" autopcomplete="off" class="form-control" id="hospital_name" placeholder="Enter Facility Name">
                            @error('hospital_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_address">Address</label>
                            <input wire:model="hospital_address" type="text" autopcomplete="off" class="form-control" id="hospital_address" placeholder="Enter Facility Name">
                            @error('hospital_address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_city_name">City</label>
                            <select  wire:model="hospital_city_name" class="form-control select>
                            <option value="">--select--</option>
                            @foreach($this->citydata as $list)
                                <option value="{{ $list->city_id }}">{{ $list->city_name }}</option>
                            @endforeach
                        </select>
                            @error('hospital_city_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_pincode">Pincode</label>
                            <input wire:model="hospital_pincode" type="text" autopcomplete="off" class="form-control" id="hospital_pincode" placeholder="Enter Pincode Number">
                            @error('hospital_pincode') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-12">
                            <label for="hospital_verify_status">Hospital Verification</label>
                            <select  wire:model="hospital_verify_status" class="form-control select>
                            <option value="">--select--</option>
                                <option value="NULL">Unverify</option>
                                <option value="1">Verify</option>
                        </select>
                            @error('hospital_verify_status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
    
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_name">Lattitude</label>
                            <input wire:model="hospital_lat" type="text" autopcomplete="off" class="form-control" id="hospital_lat" placeholder="Enter Facility Name">
                            @error('hospital_lat') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="hospital_name">Longitude</label>
                            <input wire:model="hospital_long" type="text" autopcomplete="off" class="form-control" id="hospital_long" placeholder="Enter Facility Name">
                            @error('hospital_long') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <input type="hidden" wire:model="hospital_id">
                    <div class="row align-items-center justify-content-end">
                        <!-- <div class="col-6"><button type="button" class="submit__btn btn-danger py-2 px-3 rounded" id="btnclose" data-dismiss="modal">Close</button></div> -->
                        <div class="">
                            <button wire:click.prevent="UpdateHospitalData()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $hospital_id ? 'Update' : 'Submit' }}
                                <div wire:loading wire:target="UpdateHospitalData" wire:key="UpdateHospitalData()"><i class="fa fa-spinner fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
