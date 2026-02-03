@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Komponen Gaji</h4>
        <a href="{{ route('admin.payroll.components.create') }}" class="btn btn-primary">Tambah Komponen</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-3 table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-start">Nama</th>
                        <th class="text-center">Tipe</th>
                        <th class="text-center">Jenis Perhitungan</th>
                        <th class="text-end">Nilai</th>
                        <th class="text-center" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($components as $component)
                    <tr>
                        <td class="text-start">{{ $component->name }}</td>
                        <td class="text-center">{{ ucfirst($component->type) }}</td>
                        <td class="text-center">{{ ucfirst($component->calculation_type) }}</td>
                        <td class="text-end">
                            @if($component->calculation_type == 'percent')
                                {{ $component->value }} %
                            @else
                                Rp {{ number_format($component->value, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.payroll.components.edit', $component) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="{{ route('admin.payroll.components.destroy', $component) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus komponen ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada komponen gaji.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
