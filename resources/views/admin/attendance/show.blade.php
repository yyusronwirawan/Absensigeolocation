@extends('layouts.admin')

@section('title')
    Absen
@endsection

@push('css')
    <link rel="stylesheet"
        href="{{ asset('template/admin') }}/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/pages/datatables.css" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Detail Absen
        </h4>

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item"><a class="nav-link active" href="{{ route('attendance.index') }}"><i
                        class="bx bx-arrow-back me-1"></i>
                    Kembali</a></li>
        </ul>

        <div class="card">
            <div class="card-body">
                <p>Nama : {{ $attendance->employee->name }}</p>
                <p>Jabatan : {{ $attendance->employee->position->name }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="filter_month" style="cursor:pointer;" class="form-select" name="filter_month">
                                <option disabled selected>-- Pilih Bulan --</option>
                                @php
                                    for ($m = 1; $m <= 12; ++$m) {
                                        $month_label = date('F', mktime(0, 0, 0, $m, 1));
                                        echo '<option value=' . $m . '>' . $month_label . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="filter_year" style="cursor:pointer;" class="form-select" id="tag_select"
                                name="filter_year">
                                <option disabled selected>-- Pilih Tahun --</option>
                                @php
                                    $year = date('Y');
                                    $min = $year - 5;
                                    $max = $year;
                                    for ($i = $max; $i >= $min; $i--) {
                                        echo '<option value=' . $i . '>' . $i . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group pull-right">
                            <button id="filter" type="submit" class="btn btn-primary">Tampilkan</button>
                            <form action="{{ route('attendance.exportAttendance') }}">
                                @csrf
                                <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}" readonly>
                                <input type="hidden" id="month" name="month" readonly>
                                <input type="hidden" id="year" name="year" readonly>
                                <button id="export" type="submit" class="btn btn-success "> Export Excel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis Absen</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url()->current() }}",
                type: "GET",
                data: function(d) {
                    d.filter_month = $('#filter_month').val();
                    d.filter_year = $('#filter_year').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                }, {
                    data: 'created_at'
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
                    data: 'photo',
                    searchable: false,
                    orderable: false
                },
            ],
        });

        $('#filter').click(function() {
            $('#data-table').DataTable().draw(true);

            var filter_month = $('#filter_month').val();
            var filter_year = $('#filter_year').val();
            $('#month').val(filter_month);
            $('#year').val(filter_year);
        });
    </script>
@endpush
