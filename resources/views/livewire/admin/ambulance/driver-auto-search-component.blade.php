<div class="container-fluid">
@include('livewire.admin.ambulance.booking-nav-component')
    <!-- Add driver -->
    <div class="card card-default add__driver__form">
      <!-- .......1....... -->
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Auto Search the Nearest Driver</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
            Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
      <div class="card-body py-1 pb-">
        <form wire:submit.prevent="generateBookingStep1Form" class="mb-5">
          <div class="row ">
           
            <div class="col-6 col-sm-4 col-md-12">
              <div class="form-group d-flex w-100 justify-content-between align-items-center">
                <div class="col-2"><label for="driver_mobile w-25">Enter Your Address</label></div>
                <div class="col-10 mt-2">
                  <input wire:model="customer_mobile" type="text" class="rounded-0 form-control form-control-sm" id="driver_mobile" placeholder="Enter Your Search Location...........">
                  @error('customer_mobile') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-12 mt-3">
              <div class="form-group d-flex align-items-center w-100">
                <div class="col-2">
                <label for="name">Select Duty Status</label>
                </div>

                    <div class="col-10 mt-2">
                      <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="onDuty" value="ON">
                      <label class="form-check-label mt-1" for="onDuty">On Duty Driver</label>
                        </div>
                      <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="offDuty" value="OFF">
                      <label class="form-check-label mt-1" for="offDuty">OFF Duty Driver</label>
                        </div>
                      <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="AllDuty" value="All">
                      <label class="form-check-label mt-1" for="AllDuty">All Driver </label>
                                        </div>
                    </div>
                @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-12 pl-3 mt-3">
              <div class="form-group row align-items-start">
                    <div class="col-2"><label for="name">Select Category Name</label></div>
                    <div class="col-10 d-flex flex-column">
                      <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="onDuty" value="ON">
                      <label class="form-check-label" for="onDuty">On Duty Driver</label>
                        </div>
                      <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="offDuty" value="OFF">
                      <label class="form-check-label" for="offDuty">OFF Duty Driver</label>
                        </div>
                      <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="AllDuty" value="All">
                      <label class="form-check-label" for="AllDuty">All Driver </label>
                                        </div>
                      <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="onDuty" value="ON">
                      <label class="form-check-label" for="onDuty">On Duty Driver</label>
                        </div>
                        <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="offDuty" value="OFF">
                      <label class="form-check-label" for="offDuty">OFF Duty Driver</label>
                        </div>
                        <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="AllDuty" value="All">
                      <label class="form-check-label" for="AllDuty">All Driver </label>
                                        </div>
                                        <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="onDuty" value="ON">
                      <label class="form-check-label" for="onDuty">On Duty Driver</label>
                        </div>
                        <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="offDuty" value="OFF">
                      <label class="form-check-label" for="offDuty">OFF Duty Driver</label>
                        </div>
                        <div class="form-check form-check-inline ">
                      <input class="form-check-input" type="radio" name="driver_duty_status" id="AllDuty" value="All">
                      <label class="form-check-label" for="AllDuty">All Driver </label>
                                        </div>
                    </div>
                @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
           
            </div>
            <div class="col-6 col-sm-auto col-md-12 ">
                <div class="row">
                  <div class="col-2">
                    <label for="name">Select Vehicle name</label>
                  </div>
                      <div class="form-group col-6 mt-2">
                          <select wire:model.live.debounce.150ms="selectedDate" wire:model="check_for" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                              <option selected value="all">All</option>
                              <option value="today">Today</option>
                              <option value="yesterday">Yesterday</option>
                              <option value="thisWeek">This Week</option>
                              <option value="custom">Custom Date</option>
                              <option value="thisMonth">This Month</option>
                          </select>
                      </div>
                      <div class="col-6 col-sm-4 mt-2">
                        <div class="form-group w-50 ml-auto">
                        <button type="submit"
                                 wire:loading.attr="disabled" 
                                 class="rounded-0 form-control form-control-sm btn-primary">
                                 <i wire:loading wire:target="step1Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> Submit
                        </button>    
                        </div>
                      </div>
                    </div>
                </div>
          </div>
        </form>
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Added</th>
                        <th>Consumer</th>
                        <th>Category</th>
                        <th>Source</th>
                        <th>Pickup</th>
                        <th>Drop</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
              
                </table>
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty">
                <div class="col">
                    <div class="loader">
                        <div class="loader-inner">
                            <div class="loading one"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading two"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading three"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading four"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
