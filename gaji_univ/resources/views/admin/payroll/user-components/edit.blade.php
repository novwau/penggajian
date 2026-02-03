@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4>Edit Komponen Gaji: {{ $user->name }}</h4>

    <form action="{{ route('admin.payroll.user-components.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Komponen</th>
                    <th>Tipe</th>
                    <th>Jenis Perhitungan</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($components as $component)
                    <tr>
                        <td>{{ $component->name }}</td>
                        <td>{{ ucfirst($component->type) }}</td>
                        <td>{{ ucfirst($component->calculation_type) }}</td>
                        <td>
                            <input type="number" name="components[{{ $component->id }}]"
                                   value="{{ $userComponents[$component->id] ?? $component->value }}"
                                   class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
