<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmployeeRegistration;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $company_admin = Employee::where('user_id', auth()->user()->id)->with('company')->first();

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
            'verification_token' => Str::Random(32),
        ]);

        $employee = Employee::create([
            'user_id' => $user->id,
            'company_id' => $company_admin->company->id,
            'joined_at' => now()->timestamp,
        ]);

        (new AttendanceController())->create($employee->id);

        Mail::to($user->email)->send(new EmployeeRegistration($user, $request->password));

        return redirect()->route('add-employee')->with('success', 'Employee added successfully');
    }

    public function add()
    {
        return view('company-admin.add-employee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $token, $userId)
    {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'password' => 'required'
        ]);

        $user = User::find($userId)->where('verification_token', $token)->first();

        if($user === null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if($user->verified) {
            if(auth()->attempt(['email' => $user->email, 'password' => $user->password])) {
                return redirect()->route('employee-home')->with('success', 'Registration completed successfully');
            }
        }

        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->password),
            'verified' => true,
            'verification_token' => null,
        ]);

        if(auth()->attempt(['email' => $user->email, 'password' => $request->password])) {
            return redirect()->route('employee-home')->with('success', 'Registration completed successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function register($verificationToken) {
        $user = User::where('verification_token', $verificationToken)->first();

        if($user === null) {
            return response()->json(['error' => 'User already verified'], 400);
        }

        return view('employee.registration', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
