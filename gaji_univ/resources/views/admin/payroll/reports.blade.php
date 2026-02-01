@extends('layouts.admin')

@section('title', 'Laporan Gaji')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Gaji</h3>
    </div>

    <div class="card-body p-0">
        @if($periods->isEmpty())
            <div class="p-4 text-muted">
                Belum ada data laporan gaji.
            </div>
        @else
        <table class="table table-hover table-spacious align-middle mb-0">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($periods as $period)
                <tr>
                    <td>
                        <strong>{{ $period->nama }}</strong>
                    </td>
                    <td>
                        {{ $period->start_date }} s/d {{ $period->end_date }}
                    </td>
                    <td>
                        <span class="badge bg-success">Tersedia</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.payroll.reports.detail', $period) }}"
                           class="btn btn-sm btn-primary">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
