<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Manager;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CompleteCompanyMail;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('employee')->get();

        //api call
        return response()->json([
            'companies' => $companies,
        ]);

        // turn on when you are testing in laravel
        // return view('super-admin.company-overview', [
        //     'companies' => $companies
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'company_name'       => 'required',
            'manager_first_name' => 'required',
            'manager_password'   => 'required',
            'manager_email'      => 'required|email|unique:users,email',
        ]);

        $manager = User::create([
            'first_name' => $request->manager_first_name,
            'email'      => $request->manager_email,
            'password'   => $request->manager_password,
            'role'       => 'company_admin'
        ]);

        $company = Company::create([
            'manager_id'         => $manager->id,
            'name'               => $request->company_name,
            'verification_token' => Str::Random(32),
        ]);

        Employee::create([
            'user_id'    => $manager->id,
            'company_id' => $company->id,
            'joined_at' => now(),
        ]);

        Manager::create([
            'user_id'    => $manager->id,
            'company_id' => $company->id,
            'start_date' => now()->timestamp,
        ]);

        Mail::to($manager)
            ->queue(new CompleteCompanyMail($manager, $company));

        return response('Company added successfully', 200);
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
    public function show($id)
    {
        // $company = Company::findOrFail($id)->with('employee.user')->first();
        $company = Company::where('id', $id)->with('employee.user')->first();

        // return json response
        return $company->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    public function verify($token, $id)
    {
        $company = Company::with('employee.user')->find($id);

        if($company === null) {
            return response()->json([
                'message' => 'Company not found'
            ], 404);
        }

        if($company->verified) {
            return response()->json([
                'message' => 'Company already verified'
            ], 400);
        }

        if ($company->verification_token !== $token) {
            return redirect('/')->with('error', 'Invalid token');
        }

        return view('company-completion', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        // web call
        $request->validate([
            'company_name'    => 'required',
            'company_adress'  => 'required',
            'company_country' => 'required',
            'company_city'    => 'required',
            'company_zip'     => 'required'
        ]);

        $company->update([
            'name'               => $request->company_name,
            'adress'             => $request->company_adress,
            'country'            => $request->company_country,
            'city'               => $request->company_city,
            'zip_code'           => $request->company_zip,
            'verified'           => true,
            'verification_token' => null,
        ]);

        // // api call
        // $request->validate([
        //     'name' => 'required',
        //     'adress' => 'required',
        //     'country' => 'required',
        //     'city' => 'required',
        //     'zip_code' => 'required',
        // ]);

        // $company->update([
        //     'name' => $request->name,
        //     'adress' => $request->adress,
        //     'country' => $request->country,
        //     'city' => $request->city,
        //     'zip_code' => $request->zip_code,
        //     'verified' => true,
        //     'verification_token' => null,
        // ]);

        // return response()->json([
        //     'message' => 'Company updated successfully',
        // ], 200);

        return redirect('/')->with('success', 'You have completed the validation process, you can now login with your temporary password given by the Buurtboer Admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        $employees = Employee::where('company_id', $company->id)->get();
        $managers = Manager::where('company_id', $company->id)->get();

        foreach ($employees as $employee){
            $employee->delete();
        }

        foreach ($managers as $manager){
            if ($manager->role !== 'super_admin') $manager->delete();
        }

        $company->delete();

        if(!$company->exists) {
            return response()->json([
                'message' => 'Company deleted successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong',
        ], 400);
    }

    public function assignAdmin(Request $request) {
        $request->validate([
            'user_id' => 'required',
        ]);

        $employee = Employee::with('user')->where('user_id', $request->user_id)->first();

        if(!$employee) {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }

        if($employee->user->role === 'company_admin') {
            return response()->json([
                'message' => 'Employee is already an admin',
            ], 400);
        }

        if($employee->user->role === 'super_admin') {
            return response()->json([
                'message' => 'Employee is a super admin',
            ], 400);
        }

        $company = Company::where('id', $employee->company_id)->first();

        Manager::create([
            'user_id'    => $request->user_id,
            'company_id' => $company->id,
            'start_date' => now()->timestamp,
        ]);

        $employee->user->update([
            'role' => 'company_admin'
        ]);

        return response()->json([
            'message' => 'Admin assigned successfully! '. $employee->user->first_name .' is now an admin of the company',
        ], 200);
    }

    public function unassignAdmin(Request $request) {
        $request->validate([
            'user_id' => 'required',
        ]);

        $employee = Employee::with('user')->where('user_id', $request->user_id)->first();

        if(!$employee) {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }

        if($employee->user->role === 'employee') {
            return response()->json([
                'message' => 'Employee is not an admin',
            ], 400);
        }

        if($employee->user->role === 'super_admin') {
            return response()->json([
                'message' => 'Employee is a super admin',
            ], 400);
        }

        $company = Company::where('id', $employee->company_id)->first();

        Manager::create([
            'user_id'    => $request->user_id,
            'company_id' => $company->id,
            'start_date' => now()->timestamp,
        ]);

        $employee->user->update([
            'role' => 'employee'
        ]);

        return response()->json([
            'message' => 'Admin unassigned successfully! '. $employee->user->first_name .' is no longer an admin of the company',
        ], 200);
    }

    public function getAdmins(Request $request) {
        $request->validate([
            'company_id' => 'required',
        ]);

        $company = Company::where('id', $request->company_id)->first();
        $admins = Employee::with(['user', 'company'])
            ->where('user.role', 'company_admin')
            ->get();

        return response()->json([
            'admins' => $admins,
        ], 200);
    }
}
