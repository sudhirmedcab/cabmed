<style>
  .submit__btn {
    height: 30px;
  }

  .add__driver__form input[type='date'] {
    height: 30px !important;
  }
</style>

<div class="content">
  <div class="container-fluid mt-2">
    <!-- Add driver -->
    <div class="card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Add Driver</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
              Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3">
        <form>
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label>Create Driver (For)</label>

                <select wire:change="partners()" wire:model="create_for" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                  <option selected value="0">Self</option>
                  <option value="1">Partner</option>
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label>Partner Name</label>

                <select wire:change="partners()" wire:model="create_for" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                  <option selected value="0">Select</option>
                  <option value="1">Partner</option>
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">Driver First Name</label>
                <input wire:model="driver_first_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter first name">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">Driver Last Name</label>
                <input wire:model="driver_first_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter last name">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_mobile">Driver Mobile</label>
                <input wire:model="driver_mobile" type="text" class="rounded-0 form-control form-control-sm" id="driver_mobile" placeholder="Enter Driver Mobile">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="vehicle_rc_no">Vehicle RC No.</label>
                <input wire:model="vehicle_rc_no" type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="vehicle_rc_no" placeholder="Enter Vehicle RC No.">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Basic Driver Details -->
    <div class="card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Driver Basic Details</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
              Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3 ">
        <form>
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
              <div class="form-group">
                <label for="exampleInputFile">Aadhaar Front Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
              <div class="form-group">
                <label for="exampleInputFile">Aadhaar Back Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">Aadhaar Number</label>
                <input wire:model="driver_first_name" type="number" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter aadhaar number">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Pan Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">Pan Number</label>
                <input wire:model="driver_first_name" type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter PAN Number">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Verification -->
    <div class="card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Verification</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
              Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3">
        <form>
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Police Verification Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">DL Front Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">DL Back Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">DL Number</label>
                <input wire:model="driver_first_name" type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter first name">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 ">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Ambulance Details -->
    <div class="card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Ambulance Details</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
              Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3">
        <form>
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Ambulance Front Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Ambulance Back Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label>Creategory</label>
                <select wire:change="partners()" wire:model="create_for" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                  <option selected value="0">Self</option>
                  <option value="1">Partner</option>
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label>Facilities</label>
                <select wire:change="partners()" wire:model="create_for" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                  <option selected value="0">Self</option>
                  <option value="1">Partner</option>
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">RC Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">RC Number</label>
                <input wire:model="driver_first_name" type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter first name">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 ">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Ambulance Fitness -->
    <div class="card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Ambulance Fitness</h3>
        <div class="card-tools ml-auto d-flex align-items-center">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
              Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3 row">
        <form>
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Fitness Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Insurance Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">Insurance Holder Name</label>
                <input wire:model="driver_first_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter Name">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Pollution Certification Image</label>
                <div class="input-group mb-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">
                      Choose file
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- /.card -->

  <!-- /.row -->
  {{-- <div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>

          <p class="card-text">
            Some quick example text to build on the card title and make up the bulk of the card's
            content.
          </p>

          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>

          <p class="card-text">
            Some quick example text to build on the card title and make up the bulk of the card's
            content.
          </p>
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div><!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h5 class="m-0">Featured</h5>
        </div>
        <div class="card-body">
          <h6 class="card-title">Special title treatment</h6>

          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Featured</h5>
        </div>
        <div class="card-body">
          <h6 class="card-title">Special title treatment</h6>

          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
    <!-- /.col-md-6 -->
  </div>
  <!-- /.row -->
</div><!-- /.container-fluid --> --}}
</div>