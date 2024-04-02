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
                <h5 class="modal-title w-100 text-center">{{ $driver_transection_id ? 'Recharge  Withdraw Amounts Details' : '' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xs"></i>
                </button>
            </div>
            <div class="modal-body px-md-4 pt-md-3 px-3 pt-1 pb-0">
                <form enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3 col-6 col-md-4">
                            <label for="driver_acc_dtl_acc_no">Bank Account</label>
                            <input wire:model="driver_acc_dtl_acc_no" disabled type="text" autopcomplete="off" class="form-control" id="driver_acc_dtl_acc_no" placeholder="Enter Bank Account Number ...">
                            @error('driver_acc_dtl_acc_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-4">
                            <label for="driver_acc_dtl_ifsc">IFSC Code:</label>
                            <input wire:model="driver_acc_dtl_ifsc" disabled type="text" autopcomplete="off" class="form-control" id="driver_acc_dtl_ifsc" placeholder="Enter The Account IFSC Code ...">
                            @error('driver_acc_dtl_ifsc') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                       
                        <div class="col-6 col-md-4">
                            <label for="driver_acc_dtl_acc_holder">Account Holder:</label>
                            <input wire:model="driver_acc_dtl_acc_holder" disabled type="text" autopcomplete="off" class="form-control" id="driver_acc_dtl_acc_holder" placeholder="Enter The Account Holder Name">
                            @error('driver_acc_dtl_acc_holder') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="form-row d-flex">
                        <div class="col-6 col-md-4">
                            <label for="ambulance_support_specialists_image_circle">Transction Slip:</label>
                            <input wire:model="cpt_transfer_image" autopcomplete="off" type="file" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" class="form-control" id="cpt_transfer_image">

                            @error('cpt_transfer_image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-6 col-md-4">
                        <label for="ambulance_catagory_desc">Payment Mode</label>
                        <select  wire:model="cpt_mode_of_payment" class="form-control select>
                            <option value="">--select--</option>
                                <option selected value="BANK">BANK</option>
                                <option value="UPI">UPI</option>
                        </select>
                            @error('cpt_mode_of_payment') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                        <div class="col-6 col-md-4">
                        <label for="driver_transection_amount">Transaction Amounts</label>
                        <input wire:model="driver_transection_amount" disabled autopcomplete="off" type="text"  class="form-control" id="driver_transection_amount" placeholder="Enter Transaction Amount ...">
                            @error('driver_transection_amount') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row col-12 mt-3">
                    <div class="mb-3 col-6 col-md-6">
                            <label for="cpt_time_transaction_id">Transaction Id:</label>
                            <input wire:model="cpt_time_transaction_id"  type="text" autopcomplete="off" class="form-control" id="cpt_time_transaction_id" placeholder="Enter Transaction Id ...">
                            @error('cpt_time_transaction_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label for="cpt_time_unix">Transaction Date</label>
                            <input wire:model="cpt_time_unix"  max="<?=date('Y-m-d')?>" type="date" autopcomplete="off" class="form-control" id="cpt_time_unix">
                            @error('cpt_time_unix') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                       
                       
                    </div>
                        
                    </div>
                    <input type="hidden" wire:model="driver_transection_id">
                    <input type="hidden" wire:model="driver_id">
                    <div class="row align-items-center justify-content-end mr-2">
                        <!-- <div class="col-6"><button type="button" class="submit__btn btn-danger py-2 px-3 rounded" id="btnclose" data-dismiss="modal">Close</button></div> -->
                        <div class="mt-3">
                            <button wire:click.prevent="storeDriverTransactionData()" wire:loading.attr="disabled" class="px-3 rounded submit__btn btn-primary float-right">{{ $driver_transection_id ? 'Submit Payment' : 'Submit' }}
                                <div wire:loading wire:target="storeDriverTransactionData" wire:key="storeDriverTransactionData()"><i class="fa fa-spinner fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
