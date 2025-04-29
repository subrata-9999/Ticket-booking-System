<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // First, sanitize the inputs
        $sanitized = [
            'email'    => filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL),
            'password' => trim($request->input('password')),
        ];

        // Then, validate the sanitized inputs
        $validator = Validator::make($sanitized, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Attempt to find the user
            $user = User::where('email', $sanitized['email'])->first();
            if (!$user || !password_verify($sanitized['password'], $user->password)) {
                DB::rollBack();
                return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
            }

            // Log the user in
            auth()->login($user);
            DB::commit();

            return redirect()->route('event.index')->with('success', 'Logged in successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['email' => 'An error occurred.'])->withInput();
        }
    }


    public function logout()
    {
         // Log out and flush session
        auth()->logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('auth.login')->with('success', 'Logged out successfully.');
    }
}
