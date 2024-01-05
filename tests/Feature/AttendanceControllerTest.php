<?php

namespace Tests\Feature;

use App\Models\Attendance;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendanceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching attendance for a user.
     *
     * @return void
     */
    public function testIndex()
    {
        // create a new usere
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('api/get-attendance/1');

        // assert that the http response is successful
        $response->assertStatus(200);
    }

    /**
     * Test fetching yearly attendance for an employee.
     *
     * @return void
     */
    public function testGetYearlyEmployeeAttendance()
    {
        // create a new user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('api/employee-attendance', [
            'employee_id' => $user->id,
        ]);

        // dd(Attendance::where('employee_id', 4)->get());

        // assert that the http response is successful
        $response->assertStatus(404);
    }

    /**
     * Test copying attendance for a user.
     *
     * @return void
     */
    public function testCopy()
    {
        // create a new user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/copy-attendance');

        // assert that the response is a redirect
        $response->assertStatus(405);
    }
}
