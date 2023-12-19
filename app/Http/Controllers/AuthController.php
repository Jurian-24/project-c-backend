<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if(auth()->attempt($validated)) {
            // add a personal access token to the user
            $token = $request->user()->createToken('access_token')->plainTextToken;

            // turn this on if using web
            if(auth()->user()->role === 'super_admin') {
                return redirect('home')->withCookie(cookie('access_token', $token, 60));
            }
            if(auth()->user()->role === 'company_admin') {
                return redirect('company-admin-dashboard')->withCookie(cookie('access_token', $token, 60));
            }

            // return redirect('employee-home')->withCookie(cookie('access_token', $token, 60));
            $user = User::where('id', auth()->user()->id)->with('employee')
            ->with('basket', function ($query) {
                $query->where('status', 'active')->first();
            })->first();
            // turn this on if using api
            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $token,
                'user' => $user
            ], 200)->header('Authorization', $token);
        }

        return response()->json([
            'message' => 'Invalid credentials',

        ], 401);
    }

    public function logout()
    {
        if(!auth()->user()) {
            return redirect('/');
        }

        auth()->user()->tokens()->delete();

        auth()->logout();

        return redirect('/');
    }

    // lbraun@example.com
}
