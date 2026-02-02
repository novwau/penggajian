@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Slip Gaji {{ $payroll->period->nama }}</h3>
    </div>

    <table>
        <tr>
            <td>Total Gaji</td>
            <td>: Rp {{ number_format($payroll->total_income) }}</td>
        </tr>
    </table>

    <hr>

    <h4>Rincian</h4>
    <ul>
        @foreach ($payroll->details as $detail)
            <li>{{ $detail->description }} — Rp {{ number_format($detail->amount) }}</li>
        @endforeach
    </ul>
</div>
@endsection
