@extends('layouts.admin')

@section('title', 'Absen')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="my_camera"></div>
                                    <br />
                                    <input type="button" value="Ambil Gambar" onClick="take_snapshot()"
                                        class="btn btn-primary me-1 mb-1">
                                    <input id="resetSnapshot" type="button" value="Reset Gambar" onClick="reset_snapshot()"
                                        class="btn btn-success me-1 mb-1 d-none">
                                    <input type="hidden" name="checkin_photo" class="image-tag">
                                </div>
                                <div class="col-md-6">
                                    <div id="results">Gambar anda akan muncul disini ...</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" id="time" name="checkin_time">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" id="latitude" name="checkin_latitude" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" id="longitude" name="checkin_longitude" />
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>

                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        Webcam.set({
            height: 250,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                document.getElementById('resetSnapshot').classList.remove('d-none');
                document.getElementById('resetSnapshot').classList.add('d-block');
            });
        }
    </script>
    <script>
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            //Tambahkan koordinat lokasi ke form absensi
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        });
    </script>
    <script>
        function displayTime() {
            var currentTime = moment().format('HH:mm:ss');
            document.getElementById("time").value = currentTime;
        }

        setInterval(displayTime, 1000);

        function reset_snapshot() {
            $img = document.querySelector('#results').querySelector('img');
            if ($img) {
                $img.remove();
                document.getElementById('resetSnapshot').classList.remove('d-block');
                document.getElementById('resetSnapshot').classList.add('d-none');
            }
        }
    </script>
@endpush
