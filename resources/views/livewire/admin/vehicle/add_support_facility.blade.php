<!-- resources/views/livewire/partner-form.blade.php -->

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
                <h5 class="modal-title w-100 text-center">{{ $ambulance_support_specialists_id ? 'Edit Ambulance Support Facility' : 'Add Ambulance Support Facility' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-4">
                            <label for="ambulance_support_specialists_name">Name</label>
                            <input wire:model="ambulance_support_specialists_name" type="text" autopcomplete="off" class="form-control" id="ambulance_facilities_name" placeholder="Enter Facility Name">
                            @error('ambulance_support_specialists_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="ambulance_support_specialists_image_circle">Image Circle</label>
                            <input wire:model="ambulance_support_specialists_image_circle" autopcomplete="off" type="file" accept="image/*" class="form-control" id="ambulance_category_icon">
                            <img id="preview_partner_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="ambulance_support_specialists_image_circle" wire:key="ambulance_support_specialists_image_circle"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i></div>

                            @error('ambulance_support_specialists_image_circle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="ambulance_support_specialists_image_squire">Image Squere</label>
                            <input wire:model="ambulance_support_specialists_image_squire" autopcomplete="off" type="file" accept="image/*" class="form-control" id="ambulance_category_icon">
                            <img id="preview_partner_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="ambulance_support_specialists_image_squire" wire:key="ambulance_support_specialists_image_squire"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i></div>

                            @error('ambulance_support_specialists_image_squire') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="form-row d-flex">
                        <div class="col-6 col-md-5">
                        <label for="select2Multiple">Select For the Category</label>
                        <select  wire:model="ambulance_support_specialists_category_name" class="form-control select2" multiple="multiple">
                            <option value="">--select--</option>
                            @foreach($ambulanceCatList as $list)
                                <option value="{{ $list->ambulance_category_type }}">{{ $list->ambulance_category_name }}</option>
                            @endforeach
                        </select>
                            @error('ambulance_support_specialists_category_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="ambulance_support_specialists_amount">Charge Amount</label>
                            <input wire:model="ambulance_support_specialists_amount" type="text" autopcomplete="off" class="form-control" id="ambulance_facilities_name" placeholder="Enter Charge Amount">
                            @error('ambulance_support_specialists_amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6 col-md-5">
                        <label for="ambulance_support_specialists_description">Add The Description</label>
                        <textarea wire:model="ambulance_support_specialists_description" rows="4" cols="60" autopcomplete="off" class="form-control" id="ambulance_support_specialists_description" placeholder="Enter Support Description Name"></textarea>
                            @error('ambulance_support_specialists_description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                        
                    </div>
                    <input type="hidden" wire:model="ambulance_support_specialists_id">
                    <div class="row align-items-center justify-content-end me-3">
                        <!-- <div class="col-6"><button type="button" class="submit__btn btn-danger py-2 px-3 rounded" id="btnclose" data-dismiss="modal">Close</button></div> -->
                        <div class="mr-5 mt-3">
                            <button wire:click.prevent="storeSupportData()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $ambulance_support_specialists_id ? 'Update' : 'Submit' }}
                                <div wire:loading wire:target="storeSupportData" wire:key="storeSupportData()"><i class="fa fa-spinner fa-spin"></i></div>
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