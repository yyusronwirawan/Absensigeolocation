@extends('layouts.admin')

@section('title', 'Riwayat Absen')

@push('css')
    <link rel="stylesheet"
        href="{{ asset('template/admin') }}/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/pages/datatables.css" />
@endpush

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Riwayat Absen</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Riwayat Absen
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Absen</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Tanggal Absen</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url()->current() }}",
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                }, {
                    data: 'name',
                    name: 'employee.name'
                },
                {
                    data: 'type'
                },
                {
                    data: 'checkin_time'
                },
                {
                    data: 'checkout_time'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (data === 'Terlambat') {
                            return '<span class="badge bg-danger badge-md">' + data + '</span>'
                        } else {
                            return '<span class="badge bg-success badge-md">' + data + '</span>'
                        }

                    }
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                },
            ],
        });
    </script>
@endpush
