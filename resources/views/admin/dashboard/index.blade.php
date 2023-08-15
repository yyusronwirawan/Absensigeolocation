@extends('layouts.admin')

@section('title', 'Dashboard')

@push('css')
    <link rel="stylesheet"
        href="{{ asset('template/admin') }}/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/pages/datatables.css" />
@endpush

@section('content')
    <div class="page-title">
        <div class="container">
            <div class="col-12 col-md-6 order-md-1 order-last mb-2">
                <h4>Menu Absensi</h4>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="row">
                            <h6 class="text-muted font-semibold text-center">
                                Absen Masuk
                            </h6>
                            <h5 class="font-extrabold mb-0 text-center">
                                @if ($data['checkRegular'])
                                    {{ $data['checkRegular']->checkin_time }}
                                @elseif($data['checkAssignment'])
                                    {{ $data['checkAssignment']->checkin_time }}
                                @else
                                    Belum Absen
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="row">
                            <h6 class="text-muted font-semibold text-center">
                                Absen Pulang
                            </h6>
                            <h5 class="font-extrabold mb-0 text-center">
                                @if ($data['checkRegular'])
                                    {{ $data['checkRegular']->checkout_time }}
                                @elseif($data['checkAssignment'])
                                    {{ $data['checkAssignment']->checkout_time }}
                                @else
                                    Belum Absen
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-xl-12 col-md-12 col-sm-12">
                @can('create attendance')
                    <a href="{{ route('attendance.create') }}" class="btn rounded-pill btn-md btn-primary mb-2">
                        Absen Masuk
                    </a>
                    <a href="{{ route('attendance.createCheckout', $data['checkRegular'] ?? ($data['checkRegular']->id ?? '')) }}"
                        class="btn rounded-pill btn-md btn-primary mb-2">
                        Absen Pulang
                    </a>
                    <a href="{{ route('attendance.createAssignmentCheckin') }}"
                        class="btn rounded-pill btn-md btn-primary mb-2">
                        Absen Penugasan Masuk
                    </a>
                    <a href="{{ route('attendance.createAssignmentCheckout', $data['checkAssignment'] ?? ($data['checkAssignment']->id ?? '')) }}"
                        class="btn rounded-pill btn-md btn-primary mb-2">
                        Absen Penugasan Pulang
                    </a>
                @endcan

                @can('create application')
                    <a href="{{ route('application.create') }}" class="btn rounded-pill btn-md btn-warning mb-2">
                        Pengajuan
                    </a>
                @endcan

            </div>
        </div>
    </section>

    @if (auth()->user()->roles()->first()->id != 3)
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Absensi Hari Ini </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($todayAttendance as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->employee->name }}</td>
                                            <td>{{ $data->status() }}</td>
                                            <td>
                                                <a href="{{ route('attendance.show', $data->id) }}"
                                                    class="btn btn-secondary btn-sm">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                Maaf, belum ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Pengajuan </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Pengajuan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($application as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->employee->name }}</td>
                                            <td>{{ $data->type() }}</td>
                                            <td>{{ $data->start_date }}</td>
                                            <td>{{ $data->end_date }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                Maaf, belum ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endpush
