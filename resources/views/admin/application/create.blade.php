@extends('layouts.admin')

@section('title')
    Pengajuan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Pengajuan
        </h4>

        <div class="card">
            <h5 class="card-header">Tambah Pengajuan</h5>
            <div class="card-body">
                <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.application.include.form')
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="{{ route('application.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
