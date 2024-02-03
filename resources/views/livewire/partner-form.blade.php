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
                <h5 class="modal-title w-100 text-center">{{ $partner_id ? 'Edit Partner' : 'Add Partner' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_f_name">First Name</label>
                            <input wire:model="partner_f_name" type="text" autopcomplete="off" class="form-control" id="partner_f_name" placeholder="Enter First Name">
                            @error('partner_f_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_l_name">Last Name</label>
                            <input wire:model="partner_l_name" type="text" autopcomplete="off" class="form-control" id="partner_l_name" placeholder="Enter Last Name">
                            @error('partner_l_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_mobile">Mobile</label>
                            <input wire:model="partner_mobile" type="text" autopcomplete="off" class="form-control" id="partner_mobile" placeholder="Enter Mobile">
                            @error('partner_mobile') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_dob">DOB</label>
                            <input wire:model="partner_dob" type="date" autopcomplete="off" class="form-control" id="datepicker" placeholder="Enter Partner DOB">
                            @error('partner_dob') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_gender">Gender</label>
                            <select wire:model="partner_gender" class="form-control">
                                <option value="Male" wire:key>Male</option>
                                <option value="Female" wire:key>Female</option>
                            </select>
                            @error('partner_gender') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_city_id">City</label>
                            <select wire:model="partner_city_id" class="form-control">
                                @foreach ($cityData as $city)
                                <option value="{{ $city->city_id }}" wire:key="partner_city_id-{{ $city->city_id }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                            @error('partner_city_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_aadhar_no">Aadhaar No.</label>
                            <input wire:model="partner_aadhar_no" autopcomplete="off" type="text" class="form-control" id="partner_aadhar_no" placeholder="Enter Partner Adhar Number">
                            @error('partner_aadhar_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 col-6 col-md-4">
                            <label for="referral_referral_by">Refferal By</label>
                            <input wire:model="referral_referral_by" autopcomplete="off" type="text" class="form-control" id="referral_referral_by" placeholder="Enter Partner Refferal By">
                            @error('referral_referral_by') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_profile_img">Image</label>
                            <input wire:model="partner_profile_img" autopcomplete="off" type="file" multiple onchange="previewImage('partner_profile_img', 'preview_partner_profile')" accept="image/*" class="form-control" id="partner_profile_img">
                            <img id="preview_partner_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="partner_profile_img" wire:key="partner_profile_img"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading</div>

                            @error('partner_profile_img') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_aadhar_front">Aadhaar Front Image</label>
                            <input wire:model="partner_aadhar_front" autopcomplete="off" multiple onchange="previewImage('partner_aadhar_front', 'preview__profile')" type="file" accept="image/*" class="form-control" id="partner_aadhar_front">
                            <img id="preview_owener_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="partner_aadhar_front" wire:key="partner_aadhar_front"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading</div>

                            @error('partner_aadhar_front') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 col-6 col-md-4">
                            <label for="partner_aadhar_back">Aadhaar Back Image</label>
                            <input wire:model="partner_aadhar_back" autopcomplete="off" multiple type="file" accept="image/*" class="form-control" id="partner_aadhar_back">
                            <img id="preview_owener_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="partner_aadhar_back" wire:key="partner_aadhar_back"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading</div>

                            @error('partner_aadhar_back') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <input type="hidden" wire:model="partner_id">
                    <div class="row align-items-center justify-content-end">
                        <!-- <div class="col-6"><button type="button" class="submit__btn btn-danger py-2 px-3 rounded" id="btnclose" data-dismiss="modal">Close</button></div> -->
                        <div class="">
                            <button wire:click.prevent="storepartner()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $partner_id ? 'Update' : 'Submit' }}
                                <div wire:loading wire:target="storepartner" wire:key="storepartner"><i class="fa fa-spinner fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>