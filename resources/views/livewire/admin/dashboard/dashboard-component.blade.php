<div class="content">

    <style>
        .custom__dashboard__data h2 {
            font-size: 16px;
        }

        .custom__dashboard__data p {
            font-size: 12px;
        }

        .custom__table__list div:nth-child(even) {
            background: #F4F6F9;
        }

        .custom__table__list>div p:last-child {
            font-weight: bold;
        }
    </style>
    <!--  -->
    <div class="card mt-2">
        <div class="card-header custom__filter__select ">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="custom__label" for="fromDate">From </label>
                        <input type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="custom__label" for="toDate">To</label>
                        <input type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="custom__label">Select</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="admin">Admin</option>
                            <option value="telecaller">Telecaller</option>
                            <option value="medcab">Medcab</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row custom__dashboard__data mb-2">
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Ambulance Booking</h2>
                        <!-- <div class="ml-auto">
                            <input type="date" wire:model.live.debounce.250ms="selectedBookingDate" max="{{ date('Y-m-d') }}" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div>
                        <div class="ml-2 bg-light px-2 border text-center">
                            <i class="fas fa-ellipsis-h text-secondary"></i>
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Enquiry Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->enquiry_booking)?$dashboardData['bookings']->enquiry_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->new_booking)?$dashboardData['bookings']->new_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Ongoing Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Invoice Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->invoice_booking)?$dashboardData['bookings']->invoice_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Completed Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->complete_booking)?$dashboardData['bookings']->complete_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Cancelled Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->cancel_booking)?$dashboardData['bookings']->cancel_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Future Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->future_booking)?$dashboardData['bookings']->future_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Booking</p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Hospital</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selectedHospitalDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Hospital </p>
                            <p class="m-0">{{$dashboardData['hospital']->total_Data}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of View Hospital </p>
                            <p class="m-0">{{$dashboardData['hospital']->total_Data}}</p>
                        </div>

                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Verified Hospital </p>
                            <p class="m-0">{{$dashboardData['hospital']->verify_hospital}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Unverified Hospital </p>
                            <p class="m-0">{{$dashboardData['hospital']->unverify_hospital}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Hospital Owner </p>
                            <p class="m-0">{{$dashboardData['hospitalOwnerdata']->total_hospitals_users}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Verified Hospital Owner</p>
                            <p class="m-0">{{$dashboardData['hospitalOwnerdata']->verify_owner}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Unverified Hospital Owner</p>
                            <p class="m-0">{{$dashboardData['hospitalOwnerdata']->unverify_owner}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Hospital</p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Wallets</h2>
                        <!-- <div class="ml-auto">
                            <input type="date" wire:model.live.debounce.250ms="selectedBookingDate" max="{{ date('Y-m-d') }}" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div>
                        <div class="ml-2 bg-light px-2 border text-center">
                            <i class="fas fa-ellipsis-h text-secondary"></i>
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Consumer Recharge </p>
                            <p class="m-0">{{($dashboardData['bookings']->enquiry_booking)?$dashboardData['bookings']->enquiry_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Driver Recharge</p>
                            <p class="m-0">{{($dashboardData['bookings']->new_booking)?$dashboardData['bookings']->new_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Partner Recharge</p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Pathology Recharge</p>
                            <p class="m-0">{{($dashboardData['bookings']->invoice_booking)?$dashboardData['bookings']->invoice_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Consumer Fetch</p>
                            <p class="m-0">{{($dashboardData['bookings']->complete_booking)?$dashboardData['bookings']->complete_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Driver Fetch</p>
                            <p class="m-0">{{($dashboardData['bookings']->cancel_booking)?$dashboardData['bookings']->cancel_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Partner Fetch</p>
                            <p class="m-0">{{($dashboardData['bookings']->future_booking)?$dashboardData['bookings']->future_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Pathology Fetch</p>
                            <p class="m-0">{{($dashboardData['bookings']->future_booking)?$dashboardData['bookings']->future_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Refer & Earn</p>
                            <p class="m-0">{{($dashboardData['bookings']->future_booking)?$dashboardData['bookings']->future_booking:"0"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row custom__dashboard__data mb-3">
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Vehicle</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selectedvehicleDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->total_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->new_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Active Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->active_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of UnderVerification Vehicle By Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->vehicle_created_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of UnderVerification Vehicle By Partner</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->driver_created_partner ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Applied Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->applied_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Expired Documents </p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Vehicle</p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Driver</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selecteddriverDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Driver </p>
                            <p class="m-0">{{$dashboardData['driverData']->total_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Driver </p>
                            <p class="m-0">{{$dashboardData['driverData']->new_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Active Driver </p>
                            <p class="m-0">{{$dashboardData['driverData']->active_driver ??"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of UnderVerification By Self Driver </p>
                            <p class="m-0">{{$dashboardData['driverData']->driver_created_self ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of UnderVerification By Partner </p>
                            <p class="m-0">{{$dashboardData['driverData']->driver_created_partner ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Applied Driver </p>
                            <p class="m-0">{{$dashboardData['driverData']->applied_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Ongoing Booking Driver </p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Expired Documents </p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Driver </p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">HealthCard</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selecteddriverDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Active HealthCard </p>
                            <p class="m-0">{{$dashboardData['driverData']->total_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New HealthCard </p>
                            <p class="m-0">{{$dashboardData['driverData']->new_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of InActive HealthCard </p>
                            <p class="m-0">{{$dashboardData['driverData']->active_driver ??"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of InCart HealthCard </p>
                            <p class="m-0">{{$dashboardData['driverData']->driver_created_self ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Expired HealthCard </p>
                            <p class="m-0">{{$dashboardData['driverData']->driver_created_partner ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked HealthCard</p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row custom__dashboard__data mb-3">
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Pathology</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selectedvehicleDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->total_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->new_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Active Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->active_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of UnderVerification Vehicle By Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->vehicle_created_driver ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of UnderVerification Vehicle By Partner</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->driver_created_partner ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Applied Vehicle</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->applied_vehicle ?? "0"}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Pathology Booking</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selecteddriverDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Enquiry Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->enquiry_booking)?$dashboardData['bookings']->enquiry_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->new_booking)?$dashboardData['bookings']->new_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Ongoing Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Invoice Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->invoice_booking)?$dashboardData['bookings']->invoice_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Completed Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->complete_booking)?$dashboardData['bookings']->complete_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Cancelled Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->cancel_booking)?$dashboardData['bookings']->cancel_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Future Booking </p>
                            <p class="m-0">{{($dashboardData['bookings']->future_booking)?$dashboardData['bookings']->future_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Vehicle</p>
                            <p class="m-0">{{"$#$"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 p-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Transaction</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selectedvehicleDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Consumer Transaction</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->total_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Driver Transaction</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->new_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Partner Transaction</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->active_vehicle ?? "0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Pathology Transaction</p>
                            <p class="m-0">{{$dashboardData['vehicleData']->vehicle_created_driver ?? "0"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-12 col-sm-6 col-md-4">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Partner</h2>
                        <div class="ml-auto">
                            <input wire:model.live="selectedpartnerDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div>
                    </div>
                    <div class="p-4" style="width: 80%; margin: auto;">
                        <canvas id="doughnutChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>
    <div class="row custom__dashboard__data mb-3">
        <div class="col-12 col-sm-6 col-md-4 p-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Partner</h2>
                        <!-- <div class="ml-auto">
                            <input type="date" wire:model.live.debounce.250ms="selectedBookingDate" max="{{ date('Y-m-d') }}" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div>
                        <div class="ml-2 bg-light px-2 border text-center">
                            <i class="fas fa-ellipsis-h text-secondary"></i>
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Partner </p>
                            <p class="m-0">{{($dashboardData['bookings']->enquiry_booking)?$dashboardData['bookings']->enquiry_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Partner </p>
                            <p class="m-0">{{($dashboardData['bookings']->new_booking)?$dashboardData['bookings']->new_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Active Partner </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Partner </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Under Registration Partner </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Vehicle </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Driver </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Consumer</h2>
                        <!-- <div class="ml-auto">
                            <input type="date" wire:model.live.debounce.250ms="selectedBookingDate" max="{{ date('Y-m-d') }}" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div>
                        <div class="ml-2 bg-light px-2 border text-center">
                            <i class="fas fa-ellipsis-h text-secondary"></i>
                        </div> -->
                    </div>
                    <div class="custom__table__list">
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Consumer </p>
                            <p class="m-0">{{($dashboardData['bookings']->enquiry_booking)?$dashboardData['bookings']->enquiry_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of New Consumer </p>
                            <p class="m-0">{{($dashboardData['bookings']->new_booking)?$dashboardData['bookings']->new_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Active Consumer </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                        <div class="d-flex justify-content-between border  py-1 px-2 rounded ">
                            <p class="m-0">Total No of Blocked Consumer </p>
                            <p class="m-0">{{($dashboardData['bookings']->ongoing_booking)?$dashboardData['bookings']->ongoing_booking:"0"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row custom__dashboard__data mb-3">
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Ambulance Booking</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selectedpartnerDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="p-4" style="width: 80%; margin: auto;">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 p-0 mb-2 mb-md-0">
            <div class="container-fluid h-100">
                <div class="card mt-2 p-2 h-100">
                    <div class="d-flex mb-2 border-bottom pb-2 align-items-center">
                        <h2 class="">Hospital</h2>
                        <!-- <div class="ml-auto">
                            <input wire:model.live="selectedpartnerDate" type="date" class="custom__input__field rounded bg-light form-control form-control-sm">
                        </div> -->
                    </div>
                    <div class="p-4" style="width: 80%; margin: auto;">
                        <canvas id="doughnutChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('doughnutChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($data1['labels']),
            datasets: [{
                data: @json($data1['data']),
                backgroundColor: [
                    'rgba(23,156,136)',
                    'rgba(195,213,214)'
                ],
                borderColor: [
                    'rgba(23,156,136)',
                    'rgba(195,213,214)'
                ],
                borderWidth: 1
            }]
        },
    });
    var ctx = document.getElementById('doughnutChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($data2['labels']),
            datasets: [{
                data: @json($data2['data']),
                backgroundColor: [
                    'rgba(23,156,136)',
                    'rgba(195,213,214)'
                ],
                borderColor: [
                    'rgba(23,156,136)',
                    'rgba(195,213,214)'
                ],
                borderWidth: 1
            }]
        },
    });
</script>