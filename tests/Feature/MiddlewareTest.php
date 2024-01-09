<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckCompanyAdmin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertEquals;

class MiddlewareTest extends TestCase
{
    /**
     * Test if the middleware returns 404 when a user is not logged in.
     */
    public function test_if_middleware_returns_not_found()
    {
        $request = new Request;

        $request->merge([
            'role' => 'company_admin',
        ]);

        $middleware = new CheckCompanyAdmin;

        $middleware->handle($request, function ($request) {
            return assertEquals(404, $request->getStatusCode());
        });

        // $response->assertStatus(200);
    }
}
