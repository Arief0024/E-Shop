<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\TransactionDetails;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = TransactionDetails::with(['transaction.user', 'product.galleries']);



        $revenue = $transactions->get()->reduce(function ($carry, $item) {
            return $carry + $item->price;
        });

        $customer = User::count();

        return view('pages.dashboard',[
            'transaction_count' => $transactions->count(),
            'transaction_data' => $transactions->get(),
            'revenue' => $revenue,
            'customer' => $customer
        ]);
    }
}