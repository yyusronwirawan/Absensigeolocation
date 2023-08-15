@extends('layouts.admin')

@section('title')
    Pegawai
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Pegawai
        </h4>

        <div class="card">
            <h5 class="card-header">Tambah Pegawai</h5>
            <div class="card-body">
                <form action="{{ route('employee.store') }}" method="POST">
                    @csrf
                    @include('admin.employee.include.form')
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="{{ route('employee.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectPosition').select2({
                allowClear: true,
                placeholder: 'Pilih Jabatan',
                ajax: {
                    url: "{{ route('position.select') }}",
                    delay: 250,
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                }
                            })
                        }
                    }
                }
            })
            $('#selectAgency').select2({
                allowClear: true,
                placeholder: 'Pilih Instansi',
                ajax: {
                    url: "{{ route('agency.select') }}",
                    delay: 250,
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                }
                            })
                        }
                    }
                }
            })
        });
    </script>
@endpush
