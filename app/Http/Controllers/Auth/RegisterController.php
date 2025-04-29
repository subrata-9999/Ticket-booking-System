<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Sanitize user inputs
        $sanitized = [
            'name'     => strip_tags(trim($request->input('name'))),
            'email'    => filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL),
            'password' => trim($request->input('password')),
        ];

        // Validate the sanitized data
        $validator = Validator::make($sanitized, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Create a new user instance
            $user = new User();
            $user->name     = $sanitized['name'];
            $user->email    = $sanitized['email'];
            $user->password = bcrypt($sanitized['password']);
            $user->save();

            DB::commit();

            return redirect()->route('auth.login')->with('success', 'Registration successful. Please log in.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
