@extends('layouts.user')

@section('content')
@php
    $alreadyCheckedIn = \App\Models\Attendance::where('user_id', auth()->id())
        ->whereDate('tanggal', now()->toDateString())
        ->exists();
@endphp
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Presensi Hari Ini</h3>
    </div>

    <form method="POST" action="{{ route('attendance.checkin') }}" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:1rem">
            <label>Status</label>
            <select name="status" required>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
            </select>
        </div>

        <div style="margin-bottom:1rem">
            <label>Bukti Foto (opsional)</label>
            <input type="file" name="photo">
        </div>

        @if ($alreadyCheckedIn)
    <button class="btn btn-secondary" disabled>
        Anda sudah presensi hari ini
    </button>
@else
    <button type="submit" class="btn btn-primary">
        Check In
    </button>
@endif

    </form>
</div>
@endsection
