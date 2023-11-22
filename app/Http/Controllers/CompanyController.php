<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Manager;
use App\Models\Employee;
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
        $companies = Company::all();

        return view('company-overview', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'company_name' => 'required',
            'manager_first_name' => 'required',
            'manager_password' => 'required',
            'manager_email' => 'required|email|unique:users,email',
        ]);

        $manager = User::create([
            'first_name' => $request->manager_first_name,
            'email' => $request->manager_email,
            'password' => $request->manager_password
        ]);

        $company = Company::create([
            'manager_id' => $manager->id,
            'name' => $request->company_name,
        ]);

        Employee::create([
            'user_id' => $manager->id,
            'company_id' => $company->id,
            'joined_at' => now()->timestamp,
        ]);

        Manager::create([
            'user_id' => $manager->id,
            'company_id' => $company->id,
            'start_date' => now()->timestamp,
        ]);

        Mail::to($manager)
            ->queue(new CompleteCompanyMail($manager, $company));

        return redirect('add-company')->with('success', 'Company added successfully');
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
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    public function verify($id) {
        $company = Company::with('employee.user')->find($id);

        return view('company-completion', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'company_name' => 'required',
            'company_adress' => 'required',
            'company_country' => 'required',
            'company_city' => 'required',
            'company_zip' => 'required'
        ]);

        $company->update([
            'name' => $request->company_name,
            'adress' => $request->company_adress,
            'country' => $request->company_country,
            'city' => $request->company_city,
            'zip_code' => $request->company_zip,
        ]);

        return redirect('/')->with('success', 'You have completed the validation process, you can now login with your temporary password given by the Buurtboer Admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect('company-overview')->with('success', 'Company deleted successfully');
    }
}
