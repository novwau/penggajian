@extends('layouts.admin')

@section('title', 'Audit Log')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Audit Log</h3>
    </div>

    <div class="card-body p-0">
        @if($logs->isEmpty())
            <div class="p-4 text-muted">
                Belum ada aktivitas tercatat.
            </div>
        @else
        <table class="table table-hover table-spacious align-middle mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>
                        {{ $log->created_at?->format('d M Y H:i') ?? '-' }}
                    </td>
                    <td>
                        {{ $log->user->name ?? 'System' }}
                    </td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td>
                        {{ $log->description }}
                    </td>
                    <td>
                        <code>{{ $log->ip_address }}</code>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    @if($logs->hasPages())
    <div class="card-footer">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
