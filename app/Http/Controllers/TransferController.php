<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('transfer.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ], [
            'receiver_id.required' => 'Penerima wajib dipilih.',
            'amount.required' => 'Nominal wajib diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.min' => 'Nominal harus lebih besar dari nol.',
        ]);

        $senderId = Auth::id();
        $receiverId = (int) $request->receiver_id;
        $amount = (float) $request->amount;

        if ($senderId === $receiverId) {
            return back()->withErrors([
                'receiver_id' => 'Tidak boleh transfer ke akun sendiri.',
            ])->withInput();
        }

        try {
            DB::transaction(function () use ($senderId, $receiverId, $amount) {
                $sender = User::where('id', $senderId)->lockForUpdate()->first();
                $receiver = User::where('id', $receiverId)->lockForUpdate()->first();

                if ($sender->balance < $amount) {
                    throw new \Exception('Saldo tidak mencukupi.');
                }

                $sender->balance -= $amount;
                $sender->save();

                $receiver->balance += $amount;
                $receiver->save();

                Transaction::create([
                    'transaction_code' => 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6)),
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'amount' => $amount,
                    'type' => 'transfer',
                    'description' => 'Transfer dari ' . $sender->name . ' ke ' . $receiver->name,
                ]);
            });

            return redirect()
                ->route('dashboard')
                ->with('success', 'Transfer berhasil.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'amount' => $e->getMessage(),
            ])->withInput();
        }
    }
}
