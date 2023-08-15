@extends('layouts.admin')

@section('title')
    Jabatan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Jabatan
        </h4>

        <div class="card">
            <h5 class="card-header">Tambah Jabatan</h5>

            <div class="card-body">
                <form action="{{ route('position.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.position.include.form')
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="{{ route('position.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
