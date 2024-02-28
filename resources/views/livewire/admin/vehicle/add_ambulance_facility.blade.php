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
                <h5 class="modal-title w-100 text-center">{{ $ambulance_facilities_id ? 'Edit Ambulance Facility' : 'Add Ambulance Facility' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                            <label for="ambulance_facilities_name">Name</label>
                            <input wire:model="ambulance_facilities_name" type="text" autopcomplete="off" class="form-control" id="ambulance_facilities_name" placeholder="Enter Facility Name">
                            @error('ambulance_facilities_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="ambulance_facilities_image">Image</label>
                            <input wire:model="ambulance_facilities_image" autopcomplete="off" type="file" accept="image/*" class="form-control" id="ambulance_category_icon">
                            <img id="preview_partner_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="ambulance_facilities_image" wire:key="ambulance_facilities_image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i></div>

                            @error('ambulance_facilities_image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                        <label for="select2Multiple">Select For the Category</label>
                        <select  wire:model="ambulance_facilities_category_type" class="form-control select2" multiple="multiple">
                            <option value="">--select--</option>
                            @foreach($ambulanceCatList as $list)
                                <option value="{{ $list->ambulance_category_type }}">{{ $list->ambulance_category_name }}</option>
                            @endforeach
                        </select>
                            @error('ambulance_facilities_category_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <input type="hidden" wire:model="ambulance_facilities_id">
                    <div class="row align-items-center justify-content-end">
                        <!-- <div class="col-6"><button type="button" class="submit__btn btn-danger py-2 px-3 rounded" id="btnclose" data-dismiss="modal">Close</button></div> -->
                        <div class="">
                            <button wire:click.prevent="storeFacility()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $ambulance_facilities_id ? 'Update' : 'Submit' }}
                                <div wire:loading wire:target="storeFacility" wire:key="storeFacility()"><i class="fa fa-spinner fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
<script>
$('#manager').on('select2:select', function (e) {
  @this.set('reporting_managers', $('#manager').select2('val'));
});
$('#manager').on('select2:unselect', function (e) {
  @this.set('reporting_managers', $('#manager').select2('val'));
});
</script>
@endscript