@extends('layouts.admin')

@section('title')
    Instansi
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Instansi
        </h4>

        <div class="card">
            <h5 class="card-header">Edit Instansi</h5>

            <div class="card-body">
                <form action="{{ route('agency.update', $agency->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @include('admin.agency.include.form')
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="{{ route('agency.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
