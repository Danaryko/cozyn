<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function orders()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->with('boardingHouse')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.my-orders', compact('transactions'));
    }
}