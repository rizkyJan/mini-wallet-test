@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Transfer Dana</strong>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('transfer.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <select name="receiver_id" class="form-control">
                            <option value="">Pilih penerima</option>

                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input
                            type="number"
                            name="amount"
                            class="form-control"
                            min="1"
                            value="{{ old('amount') }}"
                            placeholder="Masukkan nominal transfer">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Transfer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection