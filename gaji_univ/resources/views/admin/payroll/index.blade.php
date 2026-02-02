@extends('layouts.admin')

@section('content')
@php
    $selectedPeriod = $selectedPeriod ?? null;
@endphp

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Generate Gaji</h4>
    </div>

    {{-- Period Selector --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Periode Gaji</label>
                        <select name="period"
                                class="form-select"
                                onchange="this.form.submit()">
                            <option value="">— Pilih Periode —</option>
                            @foreach($periods as $p)
                                <option value="{{ $p->id }}"
                                    @selected(request('period') == $p->id)>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($selectedPeriod)
                        <div class="col-md-8 text-end">
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($selectedPeriod->start_date)->format('d M Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($selectedPeriod->end_date)->format('d M Y') }}
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(!$selectedPeriod)
        <div class="alert alert-info">
            Pilih periode untuk menampilkan dan generate gaji pegawai.
        </div>
    @else

    {{-- Action Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <strong>{{ $selectedPeriod->nama }}</strong>
        </div>

        <form method="POST"
              action="{{ route('admin.payroll.generate.bulk', $selectedPeriod) }}">
            @csrf
            <button class="btn btn-danger"
                    onclick="return confirm('Generate gaji untuk semua pegawai?')">
                Generate Semua
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Payroll Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0 table-spacious">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th class="text-end">Gaji Pokok</th>
                        <th class="text-center">Alpa</th>
                        <th class="text-end">Total Gaji</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    @php
                        $payroll = $user->payrolls->first(); // payroll untuk periode ini
                        $totalSalary = $payroll ? $payroll->net_salary : 0;
                        $alpaCount = $user->attendances->where('status', 'alpa')->count();
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <div class="small text-muted">
                                {{ $user->employee->jabatan ?? '-' }}
                            </div>
                        </td>
                        <td>{{ $user->employee->nip ?? '-' }}</td>
                        <td class="text-end">
                            Rp {{ number_format($user->employee->gaji_pokok ?? 0) }}
                        </td>
                        <td class="text-center">
                            {{ $alpaCount }}
                        </td>
                        <td class="text-end fw-semibold">
                            Rp {{ number_format($totalSalary) }}
                        </td>
                        <td class="text-center">
                            @if($payroll)
                                <span class="badge bg-success">Sudah</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!$payroll)
                                <form method="POST"
                                      action="{{ route('admin.payroll.generate.single', [$user, $selectedPeriod]) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">
                                        Generate
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Tidak ada data pegawai.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @endif
</div>
@endsection
