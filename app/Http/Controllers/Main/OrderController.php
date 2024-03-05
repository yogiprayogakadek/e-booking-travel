<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return view('main.order.index', compact('orders'));
    }

    public function detail($order_id)
    {
        $details = OrderDetail::with('package', 'order.customer')->where('order_id', $order_id)->get();
        return response()->json($details);
    }

    public function print(Request $request)
    {
        try {

            // $start = $request->start_date;
            // $end = $request->end_date;
            //             $orders = Order::with('details', 'payment', 'customer')->whereBetween('created_at', [$start, $end])->get();
            //             dd($orders);


            $start = $request->input('start_date');
            $end = $request->input('end_date');

            // Additional validation if needed

            // Format the dates if necessary
            $start = date('Y-m-d H:i:s', strtotime($start . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($end . ' 23:59:59'));

            // Retrieve orders within the date range
            $orders = Order::with('details', 'payment', 'customer')
                ->whereBetween('created_at', [$start, $end])
                ->get();

            // dd($orders);

            $pdf = \PDF::loadview('main.order.print', compact('orders', 'start', 'end'));
            $pdf->setPaper('a3', 'landscape');
            return $pdf->download('OrdersReport - ' . time() . '.pdf');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
