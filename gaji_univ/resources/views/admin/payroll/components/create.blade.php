@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Tambah Komponen Gaji</h4>

    <form action="{{ route('admin.payroll.components.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Komponen</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-select" required>
                <option value="income" @selected(old('type')=='income')>Income</option>
                <option value="deduction" @selected(old('type')=='deduction')>Deduction</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Perhitungan</label>
            <select name="calculation_type" class="form-select" required>
                <option value="fixed" @selected(old('calculation_type')=='fixed')>Fixed</option>
                <option value="daily" @selected(old('calculation_type')=='daily')>Daily</option>
                <option value="percent" @selected(old('calculation_type')=='percent')>Percent</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai</label>
            <input type="number" name="value" class="form-control" value="{{ old('value') }}" min="0" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.payroll.components.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
