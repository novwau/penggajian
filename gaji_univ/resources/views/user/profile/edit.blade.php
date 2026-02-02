@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Profil Saya</h3>
    </div>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div style="margin-bottom:1rem">
            <label>Nama</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}">
        </div>

        <div style="margin-bottom:1rem">
            <label>Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}">
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
