<div class="content">
    <div class="card text-center mt-2 mb-2">
        <div class="custom__driver__filter card-header">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs d-flex justify-content-around overflow-auto flex-nowrap">

                <!-- <li class="nav-item {{  (Request::is('booking')) && ($this->activeTab == null) ? 'active':''}}">
                    <a class="nav-link fs-1 " href="/booking" wire:navigate>All</a>
                </li> -->
                <li class="nav-item active">
                    <a class="nav-link fs-1" href="#" wire:navigate class="nav-link">Driver</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link fs-1" href="#" wire:navigate class="nav-link">Consumer</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header custom__filter__select ">
            <div class="col-12 p-0">
                <div class="form-group">
                    <label class="custom__label" for="notificationTitle">Title</label>
                    <input type="text" class="custom__input__field rounded form-control form-control-sm" id="notificationTitle" placeholder="Notification title">
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="form-group">
                    <label class="custom__label" for="notificationBody">Body</label>
                    <textarea name="notificationBody" id="notificationBody" class="rounded form-control" placeholder="Notification Body" cols="30" rows="100"></textarea>
                    <!-- <input type="tex" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date"> -->
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="status">Status</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="status">
                            <option selected value="Active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="dutyStatus">Driver Duty Status</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="dutyStatus">
                            <option selected value="onduty">On Duty</option>
                            <option value="offduty">Off Duty</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="dutyStatus">Driver Updated Time</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="dutyStatus">
                            <option selected value="month">Updated From 1 month</option>
                            <option value="week">Updated From 1 week</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="dutyStatus">Select State</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="dutyStatus">
                            <option selected value="select">Select</option>
                            <option value="up">Uttar Pradesh</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-2">
                    <div class="form-group">
                        <label class="custom__label" for="dutyStatus">Select City</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="dutyStatus">
                            <option selected value="select">Select</option>
                            <option value="lko">Lucknow</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-2 h-100 ml-auto mt-4">
                    <button type="submit"  class="h-100 rounded text-white form-control form-control-sm btn-primary">
                        Send All
                    </button>
                </div>



            </div>
        </div>
    </div>
</div>