<div class="modal fade" id="DataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Customer</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <form id="addEditForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="kode_customer" class="col-sm-3 col-form-label">Id Customer</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_customer" name="ID_CUSTOMER"
                                maxlength="6" readonly oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="NAMA" maxlength="40">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="EMAIL" maxlength="45">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="active" class="col-sm-3 col-form-label">Aktif</label>
                        <div class="col-sm-9">
                            <label class="switch">
                                <input type="hidden" name="ACTIVE" value="0">
                                <input type="checkbox" id="active" name="ACTIVE" value="1" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <!-- Add your form elements here -->
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab"
                                aria-controls="data" aria-selected="true">Alamat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
                                aria-controls="address" aria-selected="false">Alamat Kirim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab"
                                aria-controls="details" aria-selected="false">Lainnya</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data" role="tabpanel"
                            aria-labelledby="data-tab">
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat" name="ALAMAT"
                                        maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kota" name="KOTA"
                                        maxlength="20">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_pos" class="col-sm-3 col-form-label">Kode Pos</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kode_pos" name="KODEPOS"
                                        maxlength="5" inputmode="numeric">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-3 col-form-label">No Telepon</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="telepon" name="TELEPON"
                                        maxlength="15" inputmode="numeric">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pic" class="col-sm-3 col-form-label">PIC</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pic" name="PIC"
                                        maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nomor_hp" name="NOMOR_HP"
                                        maxlength="15" inputmode="numeric">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <!-- Form fields for address tab -->
                            <div class="form-group row">
                                <div class="form-check form-check-inline" style="margin-left: 10px;">
                                    <input class="form-check-input" type="checkbox" id="alamat_sama"
                                        name="ALAMAT_SAMA">
                                    <label class="form-check-label" for="alamat_sama">Kirim ke Alamat yang
                                        Sama</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_kirim" class="col-sm-3 col-form-label">Alamat Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat_kirim" name="ALAMAT_KIRIM"
                                        maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kota_kirim" class="col-sm-3 col-form-label">Kota Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kota_kirim" name="KOTA_KIRIM"
                                        maxlength="20">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_pos_kirim" class="col-sm-3 col-form-label">Kode Pos Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kode_pos_kirim"
                                        name="KODEPOS_KIRIM" maxlength="5" inputmode="numeric">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon_kirim" class="col-sm-3 col-form-label">No Telepon Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="telepon_kirim"
                                        name="TELEPON_KIRIM" maxlength="15" inputmode="numeric">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pic_kirim" class="col-sm-3 col-form-label">PIC Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pic_kirim" name="PIC_KIRIM"
                                        maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nomor_hp_kirim" class="col-sm-3 col-form-label">Nomor HP Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nomor_hp_kirim"
                                        name="NOMOR_HP_KIRIM" maxlength="15" inputmode="numeric">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <!-- Form fields for details tab -->
                            <div class="form-group row">
                                <label for="titik_gps" class="col-sm-3 col-form-label">Titik GPS</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="titik_gps" name="TITIK_GPS"
                                        maxlength="100">
                                    <button type="button" onclick="openMapModal()">Select Location</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sales"class="col-sm-3 col-form-label">Sales</label>
                                <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                                    <select class="form-control" id="sales" name="ID_SALES">
                                        <!-- Remove 'col-sm-9' class here -->
                                        @foreach ($sales as $Sales)
                                            <option value="">Pilih</option>
                                            <option value="{{ $Sales->ID_SALES }}">{{ $Sales->NAMA }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="mapModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMapModal()">&times;</span>
        <input type="text" id="addressInput" placeholder="Enter address here" oninput="geocodeAddress()">
        <ul id="locationList"></ul>
        <div id="map"></div>
        <button type="button" onclick="selectLocation()">Select this location</button>
    </div>
</div>


@push('css')
    <style>
        #map {
            height: 500px;
            width: 100%;
        }

        #locationList {
            list-style: none;
            padding: 0;
        }

        #locationList li {
            cursor: pointer;
            padding: 5px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }

        #locationList li:hover {
            background-color: #e9e9e9;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        var map;
        var marker;
        var selectedLocation;
        var geocoder;

        function initMap() {
            var initialLocation = {
                lat: -6.200000,
                lng: 106.816666
            };
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: initialLocation
            });

            geocoder = new google.maps.Geocoder();

            map.addListener('click', function(event) {
                placeMarker(event.latLng);
            });

            var titikGPSValue = document.getElementById('titik_gps').value;
            if (titikGPSValue) {
                var coords = titikGPSValue.split(',').map(Number);
                var gpsLocation = {
                    lat: coords[0],
                    lng: coords[1]
                };
                placeMarker(gpsLocation);
                map.setCenter(gpsLocation);
            }
        }

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }
            selectedLocation = location;

            map.setCenter(location);
            map.setZoom(15);
        }

        function openMapModal() {
            document.getElementById('mapModal').style.display = "block";
            google.maps.event.trigger(map, 'resize');

            var titikGPSValue = document.getElementById('titik_gps').value;
            if (titikGPSValue) {
                var coords = titikGPSValue.split(',').map(Number);
                var gpsLocation = {
                    lat: coords[0],
                    lng: coords[1]
                };
                map.setCenter(gpsLocation);
                placeMarker(gpsLocation);
            } else {
                map.setCenter({
                    lat: -6.200000,
                    lng: 106.816666
                });
                map.setZoom(15);
            }
        }

        function closeMapModal() {
            document.getElementById('mapModal').style.display = "none";
        }

        function selectLocation() {
            if (selectedLocation) {
                document.getElementById('titik_gps').value = selectedLocation.lat() + ', ' + selectedLocation.lng();
                closeMapModal();
            } else {
                alert('Please select a location on the map.');
            }
        }

        function geocodeAddress() {
            var address = document.getElementById('addressInput').value;
            const locationList = document.getElementById('locationList');
            locationList.innerHTML = '';
            var service = new google.maps.places.PlacesService(map);
            var request = {
                query: address,
                fields: ['name', 'geometry'],
            };

            service.textSearch(request, function(results, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    // console.log(results);
                    results.sort((a, b) => {
                        return b.rating - a.rating; // Sort in descending order based on rating
                    });
                    results.forEach((result) => {
                        // console.log(result.formatted_address);
                        const li = document.createElement('li');

                        // Name on top
                        const nameSpan = document.createElement('span');
                        nameSpan.textContent = result.name;
                        li.appendChild(nameSpan);

                        // Line break for separation
                        const br = document.createElement('br'); // Add a line break element
                        li.appendChild(br);

                        // Address below
                        const addressSpan = document.createElement('span');
                        addressSpan.textContent = result.formatted_address;
                        li.appendChild(addressSpan);

                        li.addEventListener('click', () => {
                            map.setCenter(result.geometry.location);
                            placeMarker(result.geometry.location);
                            locationList.innerHTML = '';
                        });

                        locationList.appendChild(li);

                    });
                } else {
                    alert('Gagal Mencari Alamat');
                }
            })
        }
    </script>
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap&libraries=places,marker">
    </script>
    <script>
        function validateNumberInput(input) {
            // Menghapus karakter selain angka menggunakan regular expression
            input.value = input.value.replace(/\D/g, '');
        }

        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_customer = formData.get('ID_CUSTOMER');
            var nama = formData.get('NAMA');
            var email = formData.get('EMAIL');
            var idSales = $('#sales').val();
            if (kode_customer.trim() === '') {
                toastr.error('Kode Barang harus diisi');
                $('#kode_customer').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama.trim() === '') {
                toastr.error('Nama harus diisi');
                $('#nama').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                toastr.error('Email tidak valid');
                $('#email_salesman').addClass('is-invalid');
                return false;
            }

            if (idSales == '' || idSales == null) {
                toastr.error('Id Sales harus diisi');
                return false;
            }
            return true; // Mengembalikan true jika semua validasi berhasil
        }

        function clearModal() {
            $('#kode_customer').val('');
            $('#nama').val('');
            $('#alamat').val('');
            $('#kota').val('');
            $('#kode_pos').val('');
            $('#email').val('');
            $('#telepon').val('');
            $('#pic').val('');
            $('#nomor_hp').val('');
            $('#alamat_kirim').val('');
            $('#kota_kirim').val('');
            $('#kode_pos_kirim').val('');
            $('#telepon_kirim').val('');
            $('#pic_kirim').val('');
            $('#nomor_hp_kirim').val('');
            $('#titik_gps').val('');
            $('#sales').val(null).trigger('change');

            if ($('#addEditForm input[name="_method"]').length > 0) {
                $('#addEditForm input[name="_method"]').remove(); // Hapus input tersembunyi untuk metode PUT
            }
        }

        $(document).ready(function() {
            $('#sales').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });
            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode'); // Mengambil mode dari tombol
                $('#myTab a:first').tab('show');

                var modal = $(this);
                if (mode === 'add') {
                    modal.find('.modal-title').text('Tambah Customer');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_customer').removeAttr('readonly');
                    $('#addEditForm').attr('action',
                        "{{ route('customer.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Customer');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');
                    // console.log(kode);
                    $.ajax({
                        type: "GET",
                        url: "{{ url('setup/customer/getDetail') }}/" + kode,
                        success: function(data) {
                            // console.log(data);
                            // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_customer').val(data[0].ID_CUSTOMER);
                            $('#nama').val(data[0].NAMA);
                            $('#email').val(data[0].EMAIL);
                            $('#alamat').val(data[0].ALAMAT);
                            $('#kota').val(data[0].KOTA);
                            $('#kode_pos').val(data[0].KODEPOS);
                            $('#telepon').val(data[0].TELEPON);
                            $('#pic').val(data[0].PIC);
                            $('#nomor_hp').val(data[0].NOMOR_HP);
                            $('#alamat_kirim').val(data[0].ALAMAT_KIRIM);
                            $('#kota_kirim').val(data[0].KOTA_KIRIM);
                            $('#kode_pos_kirim').val(data[0].KODEPOS_KIRIM);
                            $('#telepon_kirim').val(data[0].TELEPON_KIRIM);
                            $('#pic_kirim').val(data[0].PIC_KIRIM);
                            $('#nomor_hp_kirim').val(data[0].NOMOR_HP_KIRIM);
                            $('#titik_gps').val(data[0].TITIK_GPS);
                            if (data[0].ACTIVE === 1) {
                                $('#active').prop('checked', true);
                            } else {
                                $('#active').prop('checked', false);
                            }
                            $('#sales').val(data[0].ID_SALES).trigger('change');

                            $('#addEditForm').attr('action',
                                "{{ route('customer.update') }}"
                            ); // Set rute untuk operasi edit
                            $('#addEditForm').attr('method', 'POST');
                            $('#addEditForm').append(
                                '<input type="hidden" name="_method" value="PUT">'
                            ); // Tambahkan input tersembunyi untuk metode PUT
                        }
                    });
                }
            });

            $('#DataModal').on('hide.bs.modal', function(event) {
                clearModal();
            })

            $('#alamat_sama').change(function() {
                // Jika checkbox dicentang
                if (this.checked) {
                    // Ambil nilai dari input pada tab data
                    var alamat = $('#alamat').val();
                    var kota = $('#kota').val();
                    var kode_pos = $('#kode_pos').val();
                    var telepon = $('#telepon').val();
                    var pic = $('#pic').val();
                    var nomor_hp = $('#nomor_hp').val();

                    // Assign nilai tersebut ke input pada tab alamat kirim
                    $('#alamat_kirim').val(alamat);
                    $('#kota_kirim').val(kota);
                    $('#kode_pos_kirim').val(kode_pos);
                    $('#telepon_kirim').val(telepon);
                    $('#pic_kirim').val(pic);
                    $('#nomor_hp_kirim').val(nomor_hp);
                } else {
                    // Jika checkbox tidak dicentang, kosongkan nilai input pada tab alamat kirim
                    $('#alamat_kirim').val('');
                    $('#kota_kirim').val('');
                    $('#kode_pos_kirim').val('');
                    $('#telepon_kirim').val('');
                    $('#pic_kirim').val('');
                    $('#nomor_hp_kirim').val('');
                }
            });

            $('#submitForm').click(function(e) {
                e.preventDefault(); // Menghentikan perilaku default tombol submit

                var formData = new FormData($('#addEditForm')[0]);
                var url = $('#addEditForm').attr('action');
                var type = $('#addEditForm').attr('method');
                var successCallback = function(response) {
                    if (response.success) {
                        $('.modal-backdrop').remove();
                        $('#DataModal').modal('hide');
                        $('#addEditForm')[0].reset(); // Reset the form
                        toastr.success(response.message);
                        table.draw();
                    } else {
                        // console.log(response.message);
                        toastr.error(response.message);
                        table.draw();
                    }
                };
                var errorCallback = function(error) {
                    console.error('Terjadi kesalahan:', error);
                    toastr.error(error.responseJSON.message);
                };
                // dd(formData);
                // console.log(formData);
                // Memanggil fungsi cekData untuk memvalidasi data sebelum dikirim ke server
                if (cekData(formData)) {
                    formData.set('ID_SALES', $('#sales').val());
                    submitForm(formData, url, type, successCallback, errorCallback);
                }
            });

            $(document).on('click', '#kode_customer', function() {
                $('#kode_customer').removeClass('is-invalid');
            })

            $(document).on('click', '#nama', function() {
                $('#nama').removeClass('is-invalid');
            })

            $(document).on('click', '#email', function() {
                $('#email').removeClass('is-invalid');
            })

            $('#kode_pos').on('input', function() {
                validateNumberInput(this);
                $(this).val($('#kode_pos').val());
            })

            $('#kode_pos_kirim').on('input', function() {
                validateNumberInput(this);
                $(this).val($('#kode_pos_kirim').val());
            })

            $('#telepon').on('input', function() {
                validateNumberInput(this);
                $(this).val($('#telepon').val());
            })

            $('#telepon_kirim').on('input', function() {
                validateNumberInput(this);
                $(this).val($('#telepon_kirim').val());
            })

            $('#nomor_hp').on('input', function() {
                validateNumberInput(this);
                $(this).val($('#nomor_hp').val());
            })

            $('#nomor_hp_kirim').on('input', function() {
                validateNumberInput(this);
                $(this).val($('#nomor_hp_kirim').val());
            })
        });
    </script>
@endpush
