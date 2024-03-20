<div class="container-fluid">
    <!-- navigation -->
    <div class="card text-center mt-2 mb-2">
        <div class="custom__driver__filter card-header">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs d-flex justify-content-around overflow-auto flex-nowrap">
                <!-- <li class="nav-item {{  (Request::is('booking')) && ($this->activeTab == null) ? 'active':''}}">
                    <a class="nav-link fs-1 " href="/booking" wire:navigate>All</a>
                </li> -->
                <li class="nav-item active">
                    <a class="nav-link fs-1" href="#" wire:navigate class="nav-link">Consumer</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link fs-1" href="#" wire:navigate class="nav-link">Driver</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link fs-1" href="#" wire:navigate class="nav-link">Partner</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Filter -->
    <div class="card card-default add__driver__form mt-2">
        <div class="px-3 custom__filter__select">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-5">
                    <div class="form-group">
                        <label class="custom__label" for="sku">Page Sku</label>
                        <input type="text" class="custom__input__field rounded form-control form-control-sm" id="sku" placeholder="Page Sku">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-5">
                    <div class="form-group">
                        <label class="custom__label" for="skuData">Sku Data</label>
                        <input type="text" class="custom__input__field rounded form-control form-control-sm" id="skuData" placeholder="Sku Data">
                    </div>
                </div>
                <div class="col-6 col-sm-2 h-100 ml-auto mt-4">
                    <button type="submit" class="h-100 rounded text-white form-control form-control-sm btn-primary">
                        Add
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-3 overflow-auto">
            <table class="table custom__table table-bordered table-sm ">
                <tr>
                    <th>SNo.</th>
                    <th>Sku</th>
                    <th>Sku Name</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Sku data</td>
                    <td>Sku name</td>
                    <td class="action__btn lbtn-group">
                        <button class="btn-primary">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </table>
            <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
            </div>

        </div>
        <!-- <div class="container">
            <div class="row" wire:loading wire:target="ambulance_category_id,driver_duty_status,filterCondition,vehicleId" wire:key="ambulance_category_id,driver_duty_status,filterCondition,vehicleId">
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
        </div> -->
    </div>
</div>