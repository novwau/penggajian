@extends('layouts.admin')

@section('title', 'Periode Gaji')

@section('content')

<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <div>
            <div class="card-title">Periode Penggajian</div>
            <small style="color:var(--gray-600)">
                Atur rentang waktu dan status penggajian
            </small>
        </div>

        <a href="{{ route('admin.payroll.periods.create') }}" class="btn btn-primary">
            Tambah Periode
        </a>
    </div>

    @if(session('success'))
        <div style="margin-bottom:1rem;color:green;font-weight:600">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:var(--gray-100);text-align:left;">
                    <th style="padding:0.75rem;">Periode</th>
                    <th style="padding:0.75rem;text-align:center;">Tanggal</th>
                    <th style="padding:0.75rem;text-align:center;width:120px;">Status</th>
                    <th style="padding:0.75rem;text-align:center;width:160px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($periods as $period)
                <tr style="border-bottom:1px solid var(--gray-200);">
                    <td style="padding:0.75rem;font-weight:600;">
                        {{ $period->nama }}
                    </td>

                    <td style="padding:0.75rem;text-align:center;">
                        {{ $period->start_date }}<br>
                        <small style="color:var(--gray-600)">
                            s/d {{ $period->end_date }}
                        </small>
                    </td>

                    <td style="padding:0.75rem;text-align:center;">
                        <span style="
                            padding:0.3rem 0.6rem;
                            border-radius:6px;
                            font-size:0.75rem;
                            font-weight:700;
                            color:white;
                            background:
                                {{ $period->status === 'active' ? 'var(--maroon)' : '' }}
                                {{ $period->status === 'draft' ? 'var(--gold)' : '' }}
                                {{ $period->status === 'closed' ? 'var(--gray-600)' : '' }};
                        ">
                            {{ strtoupper($period->status) }}
                        </span>
                    </td>

                    <td style="padding:0.75rem;text-align:center;">
                        <a href="{{ route('admin.payroll.index', ['period' => $period->id]) }}"
                           class="btn btn-outline"
                           style="font-size:0.8rem;padding:0.4rem 0.75rem;">
                            Generate
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding:1.5rem;text-align:center;color:var(--gray-600)">
                        Belum ada periode penggajian
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
