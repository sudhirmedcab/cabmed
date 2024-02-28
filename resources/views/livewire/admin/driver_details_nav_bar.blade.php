<div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('driver-detail/*') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($driver_details->driver_id)])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driver_details')">
                    Details
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/0') || ($booking_status=='0') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '0'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Enquiry')">
                    Enquiry
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/1') || ($booking_status=='1') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '1'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('New')">
                    New
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/2') || ($booking_status=='2') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '2'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Ongoing')">
                    Ongoing
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/3') || ($booking_status=='3') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '3'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Invoice')">
                    Invoice
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/4') || ($booking_status=='4') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '4'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Complete')">
                    Complete
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/5') || ($booking_status=='5') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '5'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Cancel')">
                    Cancel
                    </a>
                </li>
                <li class="nav-item {{ Request::is('driver-booking-details/*/transaction') || ($booking_status=='transaction') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> 'transaction'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Transaction')">
                    Transaction
                    </a>
                </li>
                <li class="nav-item {{ Request::is('driver-booking-details/*/map') || ($booking_status=='map') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> 'map'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Map')">
                    Map View
                    </a>
                </li>

                </ul>
            </div>
        </div>
