<div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('lab_order_details/*/Details') ? 'active' : '' }}">
                    <a  wire:navigate href="{{ route('labOrderDetails', ['orderId' => Crypt::encrypt($labtestData->customer_lab_order_id), 'filterData' => 'Details']) }}" class="custom__nav__btn nav-link fs-1">
                    Order Details
                    </a>
                </li>

                <li class="nav-item {{ Request::is('lab_order_details/*/orderDetails') || ($filterData=='orderDetails') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('labOrderDetails', ['orderId' => Crypt::encrypt($labtestData->customer_lab_order_id), 'filterData' => 'orderDetails']) }}" class="custom__nav__btn nav-link fs-1">
                    User & Order Details
                </a>
            </li>

                <li  class="nav-item {{ Request::is('labOrderDetails/*/testDetails') || ($filterData=='testDetails') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('labOrderDetails',['orderId' => Crypt::encrypt($labtestData->customer_lab_order_id),'filterData'=> 'testDetails'])}}" class="custom__nav__btn nav-link fs-1">
                    Lab Order Test
                    </a>
                </li>

                <li  class="nav-item {{ Request::is('labOrderDetails/*/timeDetails') || ($filterData=='timeDetails') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('labOrderDetails',['orderId' => Crypt::encrypt($labtestData->customer_lab_order_id),'filterData'=> 'timeDetails'])}}" class="custom__nav__btn nav-link fs-1">
                    Lab Order Patients
                    </a>
                </li>
                <!-- <li  class="nav-item {{ Request::is('labOrderDetails/*/timeSlots') || ($filterData=='timeSlots') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('labOrderDetails',['orderId' => Crypt::encrypt($labtestData->customer_lab_order_id),'filterData'=> 'timeSlots'])}}" class="custom__nav__btn nav-link fs-1">
                    Lab Order Time Slots
                    </a>
                </li> -->
                <li  class="nav-item {{ Request::is('labOrderDetails/*/labDetails') || ($filterData=='labDetails') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('labOrderDetails',['orderId' => Crypt::encrypt($labtestData->customer_lab_order_id),'filterData'=> 'labDetails'])}}" class="custom__nav__btn nav-link fs-1">
                    Lab Owner & Lab Details 
                 </a>
                </li>
               

                </ul>
            </div>
        </div>
