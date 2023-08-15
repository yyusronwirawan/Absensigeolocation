@extends('layouts.admin')

@section('title')
    Pengajuan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Pengajuan
        </h4>

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item"><a class="nav-link active" href="{{ route('application.index') }}"><i
                        class="bx bx-arrow-back me-1"></i>
                    Kembali</a></li>
        </ul>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('application.storeApprove', $application->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama_pegawai"><b>Nama Pegawai</b></label>
                                    <p>{{ $application->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keterangan_pengajuan"><b>Keterangan Pengajuan </b></label>
                                    <p class="text-justify">
                                        {{ $application->explanation }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="file_pengajuan"><b>File Pengajuan</b></label>
                                    <p>
                                        <a href="{{ asset('storage/upload/pengajuan/' . $application->file) }}"
                                            target="_blank">Pengajuan.pdf</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tanggal_awal_pengajuan"><b>Tanggal Mulai Pengajuan</b></label>
                                    <p>{{ $application->start_date }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tanggal_akhir_pengajuan"><b>Tanggal Akhir Pengajuan</b></label>
                                    <p>{{ $application->end_date }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tanggal_akhir_pengajuan"><b>Status Persetujuan</b></label>
                                    <fieldset class="form-group">
                                        <select name="status" class="form-select" id="select_status">
                                            <option selected>-- Pilih status --</option>
                                            <option value="1">Disetujui</option>
                                            <option value="3">Ditolak</option>
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
