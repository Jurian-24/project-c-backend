<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;

class EmployeeController extends Controller
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
?>