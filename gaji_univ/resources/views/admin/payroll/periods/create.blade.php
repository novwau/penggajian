@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Periode Gaji</h4>

    <form method="POST" action="{{ route('admin.payroll.periods.store') }}">
        @csrf

        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nama Periode</label>
                    <input type="text" name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                               class="form-control @error('start_date') is-invalid @enderror"
                               value="{{ old('start_date') }}">
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                               class="form-control @error('end_date') is-invalid @enderror"
                               value="{{ old('end_date') }}">
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="draft">Draft</option>
                        <option value="active">Aktif</option>
                        <option value="closed">Selesai</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('admin.payroll.periods') }}"
                   class="btn btn-secondary me-2">Batal</a>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection
