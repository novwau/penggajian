@extends('layouts.admin')

@section('title', 'Detail Laporan Gaji')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title mb-1">{{ $period->nama }}</h3>
            <small class="text-muted">
                {{ $period->start_date }} s/d {{ $period->end_date }}
            </small>
        </div>

        <a href="{{ route('admin.payroll.reports') }}"
           class="btn btn-outline">
            Kembali
        </a>
    </div>

    <div class="card-body p-0">
        @if($payrolls->isEmpty())
            <div class="p-4 text-muted">
                Tidak ada data gaji untuk periode ini.
            </div>
        @else
        <table class="table table-hover table-spacious align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th class="text-end">Gaji Pokok</th>
                    <th class="text-end">Total Gaji</th>
                    <th>Tanggal Generate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->user->name }}</td>
                    <td>{{ $payroll->user->employee->nip ?? '-' }}</td>
                    <td class="text-end">
                        Rp {{ number_format($payroll->user->employee->gaji_pokok ?? 0) }}
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($payroll->net_salary) }}
                    </td>
                    <td>
                        {{ $payroll->created_at?->format('d M Y') ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
