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
                <table class="table table-responsive-sm table-hover table-bordered"">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Jenis Pengajuan</strong></td>
                            <td>{{ $application->type() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Keterangan Pengajuan</strong></td>
                            <td>{{ $application->explanation }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Mulai</strong></td>
                            <td>{{ $application->start_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Selesai</strong></td>
                            <td>{{ $application->end_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @if ($application->status == 1)
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($application->status == 2)
                                    <span class="badge bg-warning">Belum disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>File</strong></td>
                            <td>
                                <a href="{{ asset('storage/upload/pengajuan/' . $application->file) }}" target="pdf-frame"
                                    class="btn btn-secondary btn-sm">
                                    Lihat File
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
