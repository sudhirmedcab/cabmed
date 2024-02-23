<!-- resources/views/livewire/admin/ambulance/consmer_emergency_models.blade.php -->

<div class="modal" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ 'Consumer Data In Map' }}</h5>
                <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="clearfix">
                                <div class="pull-left">
                                    <p class="text-danger"> Consumer Location</p>    
                                </div>   <br>    
                                
                       
                                    <div class="container mt-5">
                                         <div id="mapView"></div><br>
                                        </div>
                                  </div>
            </div>
        </div>
    </div>
</div>



