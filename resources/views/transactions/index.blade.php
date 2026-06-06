@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Riwayat Transaksi</strong>

        <div>
            <a href="{{ route('transactions.index', ['sort' => 'desc']) }}" class="btn btn-sm btn-primary">
                Terbaru
            </a>

            <a href="{{ route('transactions.index', ['sort' => 'asc']) }}" class="btn btn-sm btn-secondary">
                Terlama
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $transaction->transaction_code }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaction->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
</div>
@endsection