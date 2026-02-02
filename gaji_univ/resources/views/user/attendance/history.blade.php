@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Presensi</h3>
    </div>

    <table width="100%" cellpadding="8">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->tanggal }}</td>
                <td>{{ ucfirst($attendance->status) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $attendances->links() }}
</div>
@endsection
