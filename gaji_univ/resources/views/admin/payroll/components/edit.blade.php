@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Edit Komponen Gaji</h4>

    <form action="{{ route('admin.payroll.components.update', $component) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Komponen</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $component->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-select" required>
                <option value="income" @selected(old('type', $component->type)=='income')>Income</option>
                <option value="deduction" @selected(old('type', $component->type)=='deduction')>Deduction</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Perhitungan</label>
            <select name="calculation_type" class="form-select" required>
                <option value="fixed" @selected(old('calculation_type', $component->calculation_type)=='fixed')>Fixed</option>
                <option value="daily" @selected(old('calculation_type', $component->calculation_type)=='daily')>Daily</option>
                <option value="percent" @selected(old('calculation_type', $component->calculation_type)=='percent')>Percent</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai</label>
            <input type="number" name="value" class="form-control" value="{{ old('value', $component->value) }}" min="0" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.payroll.components.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
