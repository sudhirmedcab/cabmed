<div class="content">
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @include('livewire.admin.hospital.hospital_nav_bar')

        <div class="card custom__filter__responsive">
            <div class="card-header custom__filter__select ">

                <div class="row">
                    
               
                <div class="col __col-3">
                     
                    </div>
                   
                    <!-- <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="HospitalId" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div> -->
                </div>

            </div>
          
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
               </div>
                                    <div class="container mt-5">
									<div id="map" style="width: 100%; height: 400px;"></div>
							</div>
                  
                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                  </div>
            </div>
        </div>

        <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty">
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
    <script>
        function initMap() {
            var buket_map_data = @json($buket_map_data);
            
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: new google.maps.LatLng(buket_map_data[0].hospital_lat, buket_map_data[0].hospital_long),
            });

            buket_map_data.forEach(function (location) {
                var icon = {
                    url: '/assets/app_icon/hospital.png', // Replace with the URL of your custom icon
                    scaledSize: new google.maps.Size(40, 40), // Adjust the size of the icon
                };

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.hospital_lat, location.hospital_long),
                    map: map,
                    icon: icon, // Set the custom icon,
                });

                var content = '<div>' +
                    '<strong>' + 'Hospital Name :'+ location.hospital_name + '</strong><br>' + 'Hospital Address :'+
                    location.hospital_address + 
                    '</div>';

                    var infowindow = new google.maps.InfoWindow({
                content: content,
                });

                marker.addListener('mouseover', function () {
                    infowindow.open(map, marker);
                }, { passive: true });

                marker.addListener('mouseout', function () {
                    infowindow.close();
                }, { passive: true });

            });
        }

</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=initMap" async defer ></script>
    

 

