<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        //api call
        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Show the requested user
     */
    public function show($id)
    {
        $user = User::find($id)->with('employee')->first();

        return response()->json([
            'user' => $user
        ]);
    }
}
