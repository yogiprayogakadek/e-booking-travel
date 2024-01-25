<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'role' => 'customer',
                'is_active' => true,
            ];

            if($request->hasFile('photo')) {
                $fileExtension = $request->file('photo')->getClientOriginalExtension();
                $fileName = str_replace(' ', '', $request->name) . '-' . time() . '.' . $fileExtension;
                $savePath = 'assets/uploads/users';

                if(!file_exists($savePath)) {
                    mkdir($savePath, 666, true);
                }

                $request->file('photo')->move($savePath, $fileName);
                $data['photo'] = $savePath . '/' . $fileName;
            }

            User::create($data);

            return redirect()->route('login')->with([
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
            ])->withInput();
        }
    }
}
