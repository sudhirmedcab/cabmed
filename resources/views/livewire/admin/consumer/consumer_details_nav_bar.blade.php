<div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('consumer-detail/*') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('consumer-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id)])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driver_details')">
                    Details
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('consumer-booking-details/*/0') || ($booking_status=='0') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> '0'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Enquiry')">
                    Enquiry
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('consumer-booking-details/*/1') || ($booking_status=='1') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> '1'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('New')">
                    New
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('consumer-booking-details/*/2') || ($booking_status=='2') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> '2'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Ongoing')">
                    Ongoing
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('consumer-booking-details/*/3') || ($booking_status=='3') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> '3'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Invoice')">
                    Invoice
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('consumer-booking-details/*/4') || ($booking_status=='4') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> '4'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Complete')">
                    Complete
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('consumer-booking-details/*/5') || ($booking_status=='5') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> '5'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Cancel')">
                    Cancel
                    </a>
                </li>
                <li class="nav-item {{ Request::is('consumer-booking-details/*/transaction') || ($booking_status=='0') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> 'transaction'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Transaction')">
                     Booking Payments
                    </a>
                </li>
                <li class="nav-item {{ Request::is('consumer-booking-details/*/consumer_transaction') || ($booking_status=='consumer_transaction') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('consumer-booking-details',['consumerId' => Crypt::encrypt($consumerDetails->consumer_id),'booking_status'=> 'consumer_transaction'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Map')">
                     Transaction
                    </a>
                </li>

                </ul>
            </div>
        </div>
