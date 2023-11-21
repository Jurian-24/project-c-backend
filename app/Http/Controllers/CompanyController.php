<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
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
        $validate = $request->validate([
            'company_name' => 'required',
            'adress' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'building' => 'required'
        ]);


        Company::create([
            'manager_id' => auth()->user()->id,
            'name' => $request->company_name,
            'adress' => $request->adress,
            'country' => $request->country,
            'city' => $request->city,
            'zip_code' => $request->zip,
            'building' => $request->building
        ]);

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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
