@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Slip Gaji</h3>
    </div>

    <table width="100%" cellpadding="8">
        <thead>
            <tr>
                <th>Periode</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($payrolls as $payroll)
            <tr>
                <td>{{ $payroll->period->nama }}</td>
                <td>{{ $payroll->created_at->format('d M Y') }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('payroll.show', $payroll) }}">
                        Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Belum ada slip gaji</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
