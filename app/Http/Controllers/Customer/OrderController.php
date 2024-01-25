<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();

        return view('customer.order.index', compact('orders'));
    }

    public function detail($order_id) {
        $details = OrderDetail::with('package')->where('order_id', $order_id)->get();
        // dd($details);
        return response()->json($details);
    }
}
