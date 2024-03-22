
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

<!------------------------------------------------------- Model Form Data For Partner Data ----------------------------------->

<div class="modal" id="partnerModal" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 align-items-center">
                <h5 class="modal-title w-100 text-center">{{ $this->language_id ? 'Edit Language Data' : 'Add Language Data' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-6">
                            <label for="language_symbol">Symbol</label>
                            <input wire:model="language_symbol" type="text" autopcomplete="off" class="form-control" id="language_symbol" placeholder="Enter Symbol Name">
                            @error('language_symbol') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="language_name">Name</label>
                            <input wire:model="language_name" type="text" autopcomplete="off" class="form-control" id="language_name" placeholder="Enter Language Name">
                            @error('language_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="language_name_en">English Name</label>
                            <input wire:model="language_name_en" type="text" autopcomplete="off" class="form-control" id="language_name_en" placeholder="Enter English Name">
                            @error('language_name_en') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     
                        <div class="col-6 col-md-6">
                            <label for="language_icons">Category Icon</label>
                            <input wire:model="language_icons" autopcomplete="off" type="file" accept="image/*" class="form-control" id="language_icons">
                            <img id="preview_partner_profile" src="#" alt="Preview Image" style="display: none; max-width: 17%; max-height: 86px;">
                            <div wire:loading wire:target="language_icons" wire:key="language_icons"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i></div>

                            @error('language_icons') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
    
                    </div>
                  
                    <input type="hidden" wire:model="language_id">
                    <div class="row align-items-center justify-content-end">
                        <div class="">
                            <button wire:click.prevent="saveLanguagedata()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $language_id ? 'Update' : 'Submit' }}
                                <div wire:loading wire:target="saveLanguagedata" wire:key="saveLanguagedata()"><i class="fa fa-spinner fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
