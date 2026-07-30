<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PaymentController extends Controller
{
    public function showProof(Order $order)
    {
        return view('admin.orders.payment-proof', compact('order'));
    }
}
