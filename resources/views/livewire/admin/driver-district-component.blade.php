<div class="content">
  <div class="container-fluid">
    @include('livewire.admin.driver-nav-component')
    <div class="card">
      <div class="card-header custom__filter__select">
        <div class="row">
          <div class="col-6 col-md-2">
            <div class="form-group">
              <label class="custom__label " for="vehicle_rc_no">Export Data</label>
              <button style="line-height:0" class="custom__input__field form-control btn-primary text-white rounded-0 form-control-sm">
                <p class="m-0 p-0">Export &nbsp; <i class="fa fa-download" aria-hidden="true"></i></p>
              </button>
            </div>
          </div>
          <div class="col-6 col-md-5">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="district_state" wire:loading.attr="disabled" wire:target="district_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="district_state">
                @foreach ($state as $list)
                <option {{ $list->state_id === 27 ? 'selected' : ''}} value="{{ $list->state_id }}">{{ $list->state_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="district_state" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
            </div>
          </div>
        </div>

      </div>
      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
          <tr>
            <th>Sr.NO.</th>
            <th>District Name </th>
            <th>Total Driver ({{ $sumDriverCountsByDistrict}})</th>
            <th>On Duty Driver</th>
            <th>OFF Duty Driver</th>
            <th>State Name</th>
          </tr>
          @php
          $srno = 1
          @endphp
          <tr>
            @foreach($results as $list)
          <tr>
            <td class="table-plus">{{$srno}}</td>
            <td>{{$list->district_name}}</td>
            <td>{{$list->total_driver_count}}</td>
            <td>{{$list->on_duty_count}}</td>
            <td>{{$list->off_duty_count}}</td>
            <td>{{$list->state_name}}</td>
          </tr>
          @php
          $srno++
          @endphp
          @endforeach

          </tr>


        </table>
        <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
        <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
          {!! $results->links() !!}
        </div>
      </div>
    </div>


  </div>
</div>
</div>