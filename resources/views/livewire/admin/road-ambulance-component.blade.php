<div class="content">

  <style>
    .text-center {
      font-size: 10px;
      text-align: center !important;
    }

    label:not(.form-check-label):not(.custom-file-label) {
      font-weight: 400;
      font-size: small;
    }

    .custom-file-input,
    .custom-select,
    .form-control {
      font-size: small;
      border-radius: 8px;
    }
  </style>

  <div class="container-fluid">
    @if ($isOpen)
    @include('livewire.employee-form')
    @endif

    @if (session()->has('message') && session()->has('type') == 'delete')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
      <strong>{{ session('message') }}!</strong>
    </div>
    @elseif (session()->has('message') && session()->has('type') == 'store')
    <div class="alert alert-success alert-dismissible" role="alert">
      <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
      <strong>{{ session('message') }}!</strong>
    </div>
    @endif

    <div class="card text-center">
      <div class="card-header pt-1 pb-3">
        <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
          <li class="nav-item">
            <!-- <a  class="ml-4  btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a> -->
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" wire:click="showNested(null)">All Booking </a>
            <div wire:loading wire:target="showNested(null)" wire:key="showNested(null)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>

          </li>

          <li class="nav-item">
            <a wire:click="showNested(0)" class="nav-link fs-1 no-border @if($activeTab === 0) active @endif">Enquiry Booking</a>
            <div wire:loading wire:target="showNested(0)" wire:key="showNested(0)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>

          <li class="nav-item">
            <a wire:click="showNested(1)" class="nav-link fs-1 no-border">New Booking</a>
            <div wire:loading wire:target="showNested(1)" wire:key="showNested(1)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>
          <li class="nav-item">
            <a wire:click="showNested(2)" class="nav-link fs-1 no-border">Ongoing Booking</a>
            <div wire:loading wire:target="showNested(2)" wire:key="showNested(2)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>
          <li class="nav-item">
            <a wire:click="showNested(3)" class="nav-link fs-1 no-border">Invoice Booking</a>
            <div wire:loading wire:target="showNested(3)" wire:key="showNested(3)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>
          <li class="nav-item">
            <a wire:click="showNested(4)" class="nav-link fs-1 no-border">Complete Booking</a>
            <div wire:loading wire:target="showNested(4)" wire:key="showNested(4)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>
          <li class="nav-item">
            <a wire:click="showNested(5)" class="nav-link fs-1 no-border">Cancel Booking</a>
            <div wire:loading wire:target="showNested(5)" wire:key="showNested(5)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>
          <li class="nav-item">
            <a wire:click="showNested(6)" class="nav-link fs-1 no-border">Future Booking</a>
            <div wire:loading wire:target="showNested(6)" wire:key="showNested(6)"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </li>

        </ul>
      </div>

    </div>

    <div class="card">
      <div class="card-header text-center mb-3">
        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="inputEmail4">From Date</label>
            <input type="date" @if($notfilterValue) disabled @endif wire:model="from_filter" class="form-control" wire:model.live.debounce.150ms="fromdate">
            <div wire:loading wire:target="fromdate" wire:key="fromdate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
          </div>
          <div class="form-group col-md-2">
            <label for="inputEmail4">To Date</label>
            <input type="date" @if($notfilterValue) disabled @endif wire:model="to_filter" class="form-control" wire:model.live.debounce.150ms="todate">
            <div wire:loading wire:target="todate" wire:key="todate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>

          </div>


          <div class="form-group col-md-3">
            <label for="inputEmail4">Select Filter</label>
            <select @if($filterValue) disabled @endif wire:model.live.debounce.150ms="dateOption" wire:model="date_filter" class="form-control">
              <option value="">Choose Data ....</option>
              <option value="today" wire:key>Today</option>
              <option value="yesterday" wire:key>Yesterday</option>
              <option value="week" wire:key>This Week</option>
              <option value="month" wire:key>This Month</option>
              <option value="all" wire:key>All</option>
            </select>
          </div>
          <div wire:loading wire:target="date_filter" wire:key="date_filter"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>

          <div class="form-group col-md-5 pt-3">
            <label for="inputEmail4">{{$booking_filter}}</label>
          </div>
        </div>
        <div class="card-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="search" wire:model.live.debounce.150ms="search" class="form-control float-right" placeholder="Search">

            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-0">
        <table class="table table-sm">
          <tr>
            <th>Enquiry ID</th>
            <th>Consumer Name.</th>
            <th>Pickup Loction</th>
            <th>Drop Loction</th>
            <th>Remark Details</th>
            <th>Booking Status</th>
            <th>Action</th>
          </tr>
          <tr>
            @if(!empty($bookingData))
            <?php $sr = 1; ?>
            @foreach($bookingData as $enquirys)
          <tr>
            <td>Booking Id ({{$enquirys->booking_id}})<br>@if($enquirys->created_at)
              Create Date: {{date("j F, Y h:i A" , strtotime($enquirys->created_at))}} @else @endif<br>Schedule Time:<p class="text-danger"><i class="dw dw-edit2"></i> {{$enquirys->booking_schedule_time}}</p>
            </td>
            <td>{{$enquirys->booking_con_name}}<br>
              <p>{{$enquirys->booking_con_mobile}}</p>
            </td>

            <td>{!!wordwrap($enquirys->booking_pickup,25,"<br>\n")!!}</td>
            <td>{!!wordwrap($enquirys->booking_drop,25,"<br>\n")!!}</td>
            <td> @if(($enquirys->remark_id))
              {{$enquirys->remark_text}}@else N/A @endif
            </td>

            <td>
              <p>
                @if ($enquirys->booking_status == '0')
                Enquiry type
                @elseif ($enquirys->booking_status == '1')
                Booking Done
                @elseif ($enquirys->booking_status == '2')
                Driver Assigned
                @elseif ($enquirys->booking_status == '3')
                Invoice Assigned
                @elseif ($enquirys->booking_status == '4')
                Booking Complete
                @elseif ($enquirys->booking_status == '5')
                Booking Cancel
                @elseif ($enquirys->booking_status == '6')
                Booking Future
                @else
                @endif
              </p>


            </td>
            <td class="action__btn lbtn-group">
              <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
              <button wire:confirm="Are you sure you want to delete this Booking?" wire:click="delete({{ $enquirys->booking_id }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
          @endforeach
          @endif

        </table>
      </div>
    </div>

    <div class="float-right">
      <div class="card-footer clearfix">
        {!! $bookingData->links() !!}
      </div>
    </div>


  </div>
</div>
</div>