@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4>Selamat datang, {{ $user->name }}</h4>

        <p class="mb-1">Saldo Anda:</p>
        <h2>Rp{{ number_format($user->balance, 0, ',', '.') }}</h2>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <strong>Riwayat Transaksi Terbaru</strong>
    </div>

    <div class="card-body">
        @forelse($transactions as $transaction)
        <div class="border-bottom py-2">
            <div>
                <strong>{{ $transaction->transaction_code }}</strong>
            </div>

            <div>{{ $transaction->description }}</div>

            <div>
                Rp{{ number_format($transaction->amount, 0, ',', '.') }}
            </div>

            <small>
                {{ $transaction->created_at->format('d M Y H:i') }}
            </small>
        </div>
        @empty
        <p class="text-muted mb-0">Belum ada transaksi.</p>
        @endforelse
    </div>
</div>
@endsection