@extends('layouts.admin')

@section('title')
    Absen
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Absen
        </h4>

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item"><a class="nav-link active" href="{{ route('attendance.index') }}"><i
                        class="bx bx-arrow-back me-1"></i>
                    Kembali</a></li>
        </ul>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_pegawai"><b>Nama Pegawai</b></label>
                                    <p>{{ $attendance->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="latitude"><b>Latitude Absen Masuk </b></label>
                                    <input class="form-control" type="text" name="checkin_latitude"
                                        value="{{ isset($attendance) ? $attendance->checkin_latitude : old('checkin_latitude') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="longitude"><b>Longitude Absen Masuk </b></label>
                                    <input class="form-control" type="text" name="checkin_longitude"
                                        value="{{ isset($attendance) ? $attendance->checkin_longitude : old('checkin_longitude') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="time"><b>Waktu Absen Masuk</b></label>
                                    <input class="form-control" type="text" name="checkin_time"
                                        value="{{ isset($attendance) ? $attendance->checkin_time : old('checkin_time') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="latitude"><b>Latitude Absen Pulang </b></label>
                                    <input class="form-control" type="text" name="checkout_latitude"
                                        value="{{ isset($attendance) ? $attendance->checkout_latitude : old('checkout_latitude') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="longitude"><b>Longitude Absen Pulang </b></label>
                                    <input class="form-control" type="text" name="checkout_longitude"
                                        value="{{ isset($attendance) ? $attendance->checkout_longitude : old('checkout_longitude') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="time"><b>Waktu Absen Pulang</b></label>
                                    <input class="form-control" type="text" name="checkout_time"
                                        value="{{ isset($attendance) ? $attendance->checkout_time : old('checkout_time') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type"><b>Jenis Absen</b></label>
                                    <fieldset class="form-group">
                                        <select name="type" class="form-select" id="select_type">
                                            <option selected>-- Pilih jenis absen --</option>
                                            <option value="1"
                                                {{ isset($attendance) && $attendance->type == 1 ? 'selected' : (old('type') == 1 ? 'selected' : '') }}>
                                                Reguler</option>
                                            <option value="2"
                                                {{ isset($attendance) && $attendance->type == 2 ? 'selected' : (old('type') == 2 ? 'selected' : '') }}>
                                                Penugasan</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" id="alertApproval" class="btn btn-primary me-1 mb-1">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
