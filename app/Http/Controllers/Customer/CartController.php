<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    protected function order_code() {
        return 'trans-' . bin2hex(random_bytes(6));
    }

    public function index(Request $request)
    {
        return view('customer.cart.index');
    }

    public function render()
    {
        $view = [
            'data' => view('customer.cart.render')->with([
                'cart' => cart()
            ])->render(),
        ];

        return response()->json($view);
    }

    public function update(Request $request)
    {
        $user_id = auth()->user()->id;
        $package = Package::find($request->id);
            \Cart::session($user_id)->update($request->id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Quantity updated',
                'title' => 'Success',
                // 'cart' => cart(),
                // 'subtotal' => subTotal()
            ]);
        // }
    }

    public function payment(Request $request)
    {
        try {
            DB::beginTransaction();

            // Insert to order table
            $order = Order::create([
                'order_code' => $this->order_code(),
                'user_id' => Auth::user()->id,
            ]);

            // insert into detail order
            foreach (cart() as $key => $value) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'package_id' => $value->associatedModel['id'],
                    'quantity' => $value->quantity,
                    'order_date' => $value->attributes['order_date'],
                    'order_message' => $value->attributes['order_message'],
                ]);
            }

            // insert into pembayaran
            Payment::create([
                'order_id' => $order->id,
                'total' => \Cart::session(Auth::user()->id)->getSubtotal(),
                'status' => 'Unpaid',
                // 'payment_payload' => '',
            ]);

            // Return midtrans payload
            $midtransToken = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => \Cart::session(Auth::user()->id)->getSubTotal(),
                ],
                'customer_details'  => [
                    'first_name' => Auth::user()->name,
                    'last_name' => '',
                    'email'      => Auth::user()->email,
                    'phone'       => Auth::user()->phone
                ],
            ];

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Waiting',
                'title' => 'Berhasil',
                'midtransToken' => \Midtrans\Snap::getSnapToken($midtransToken)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if($hashed == $request->signature_key) {
            if($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $payment = Payment::where('order_id', $request->order_id);
                $payment->update([
                    'status' => 'Paid',
                    'payment_payload' => json_encode($request->all())
                ]);
            }
        }
    }

    public function paymentChecking(Request $request)
    {
        try {
            if($request->status_code == 200) {
                // update order status
                $order = Order::where('id', $request->order_id);
                $order->update([
                    'status' => 'Success'
                ]);

                // clear all shopping cart
                \Cart::session(Auth::user()->id)->clear();
            }
            // $view = [
            //     'data' => view('customer.package.index')->render()
            // ];
            return response()->json([
                'status' => 'success',
                'message' => 'Payment success',
                'title' => 'Success',
                // 'render' => $view
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Failed'
            ]);
        }
    }
}
