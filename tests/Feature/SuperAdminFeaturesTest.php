<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class SuperAdminFeaturesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_company()
    {
        $company = Company::create([
            'manager_id' => '1',
            'name' => 'Test Company',
            'adress' => 'Test Adress',
            'country' => 'Test Country',
            'city' => 'Test City',
            'zip_code' => 'Test Zip Code',
            'building' => 'Test Building',
            'verified' => false,
            'verification_token' => 'Test Verification Token',
        ]);

        $companyFound = Company::find($company->id) != null;

        return assertEquals($companyFound, true);
    }
    
    public function test_remove_company()
    {
        $company = Company::factory()->make();

        $company->delete();

        $companyFound = Company::find($company->id) != null;

        return assertEquals($companyFound, false);
    }
}
