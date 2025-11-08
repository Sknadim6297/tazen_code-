<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Professional;
use App\Models\SubService;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class SubServiceBookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_sub_service_data_in_booking()
    {
        // Create test user
        $user = User::factory()->create();
        
        // Create test professional
        $professional = Professional::factory()->create();
        
        // Create test sub-service
        $subService = SubService::factory()->create([
            'name' => 'Test Sub Service',
            'description' => 'Test Description'
        ]);

        // Act as the user
        $this->actingAs($user, 'user');

        // Set up session data
        session([
            'booking_data' => [
                'professional_id' => $professional->id,
                'plan_type' => 'monthly',
                'bookings' => [
                    [
                        'date' => now()->addDay()->format('Y-m-d'),
                        'time_slot' => '10:00 AM - 11:00 AM'
                    ]
                ]
            ],
            'selected_service_name' => 'Test Service'
        ]);

        // Make request with sub-service data
        $response = $this->postJson('/booking/store', [
            'phone' => '1234567890',
            'sub_service_id' => $subService->id,
            'sub_service_name' => $subService->name
        ]);

        // Assert successful response
        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Your booking has been successfully placed.'
                ]);

        // Assert booking was created with sub-service data
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'professional_id' => $professional->id,
            'sub_service_id' => $subService->id,
            'sub_service_name' => $subService->name,
            'customer_phone' => '1234567890'
        ]);
    }

    /** @test */
    public function it_can_create_booking_without_sub_service()
    {
        // Create test user
        $user = User::factory()->create();
        
        // Create test professional
        $professional = Professional::factory()->create();

        // Act as the user
        $this->actingAs($user, 'user');

        // Set up session data
        session([
            'booking_data' => [
                'professional_id' => $professional->id,
                'plan_type' => 'monthly',
                'bookings' => [
                    [
                        'date' => now()->addDay()->format('Y-m-d'),
                        'time_slot' => '10:00 AM - 11:00 AM'
                    ]
                ]
            ],
            'selected_service_name' => 'Test Service'
        ]);

        // Make request without sub-service data
        $response = $this->postJson('/booking/store', [
            'phone' => '1234567890'
        ]);

        // Assert successful response
        $response->assertStatus(200);

        // Assert booking was created without sub-service data
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'professional_id' => $professional->id,
            'sub_service_id' => null,
            'sub_service_name' => null,
            'customer_phone' => '1234567890'
        ]);
    }
}
