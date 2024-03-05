<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $page = 6;

    public function index(Request $request)
    {
        $packages = Package::where('is_active', true)->paginate($this->page);
        if ($request->ajax()) {
            return view('customer.package.render')->with([
                'packages' => $packages,
            ])->render();
        }
        return view('customer.package.index', compact('packages'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user_id = auth()->user()->id;
        $package = Package::find($request->package_id);
        try {
            if (\Cart::session($user_id)->get($package->id)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Package already in cart',
                    'title' => 'Failed',
                ]);
            } else {
                \Cart::session($user_id)->add([
                    'id' => $package->id,
                    'name' => json_decode($package->detail, true)['name'],
                    'price' => $package->price,
                    'quantity' => $request->quantity,
                    'associatedModel' => $package,
                    'attributes' => [
                        'order_date' => $request->order_date,
                        'order_message' => $request->order_message
                    ]
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Success to add package to cart',
                    'title' => 'Success',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal',
            ]);
        }
    }

    public function orderQuantity($param) {
        $data = explode(' ', $param);
        $package_id = $data[0];
        $date = $data[1];

        $quantity = OrderDetail::where('package_id', $package_id)
                    ->whereDate('order_date', $date)
                    ->sum('quantity');

        return response()->json($quantity);
    }
}
