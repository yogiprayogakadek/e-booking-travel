<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('main.package.index', compact('packages'));
    }

    public function create()
    {
        return view('main.package.create');
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'price' => $request->price,
                'detail' => json_encode([
                    'name' => $request->name,
                    'address' => $request->address,
                    // 'total'=> $request->total,
                    'detail'=> $request->detail
                ]),
            ];

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = str_replace(' ', '', $request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $savePath = 'assets/uploads/packages';

                if(!file_exists($savePath)) {
                    mkdir($savePath, 655, true);
                }

                $image->move($savePath, $fileName);
                $data['image'] = $savePath . '/' . $fileName;
            }

            Package::create($data);

            return redirect()->route('package.index')->with([
                'status' => 'success',
                'message' => 'Data saved successfully',
                'title' => 'Success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $e->getMessage(),
                // 'message' => 'Something went wrong',
                'title' => 'Failed'
            ]);
        }
    }

    public function edit($id)
    {
        $package = Package::find($id);

        return view('main.package.edit', compact('package'));
    }

    public function update(Request $request)
    {
        try {
            $package = Package::find($request->id);
            $data = [
                'price' => $request->price,
                'detail' => json_encode([
                    'name' => $request->name,
                    'address' => $request->address,
                    // 'total'=> $request->total,
                    'detail'=> $request->detail
                ]),
                'is_active' => $request->is_active
            ];

            if($request->hasFile('image')) {
                unlink($package->image);
                $image = $request->file('image');
                $fileName = str_replace(' ', '', $request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $savePath = 'assets/uploads/packages';

                if(!file_exists($savePath)) {
                    mkdir($savePath, 655, true);
                }

                $image->move($savePath, $fileName);
                $data['image'] = $savePath . '/' . $fileName;
            }

            $package->update($data);

            return redirect()->route('package.index')->with([
                'status' => 'success',
                'message' => 'Data saved successfully',
                'title' => 'Success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $e->getMessage(),
                // 'message' => 'Something went wrong',
                'title' => 'Failed'
            ]);
        }
    }
}
