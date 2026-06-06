<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'desc');

        $transactions = Transaction::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->orderBy('created_at', $sort === 'asc' ? 'asc' : 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'sort'));
    }
}
