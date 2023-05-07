<?php

namespace Tests\Feature;

use App\Models\Parking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use App\Services\ParkingPriceService;
use Carbon\CarbonImmutable;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ZoneSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParkingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_parking_correct_price_in_paid_interval()
    {
        $this->seed([
            CategorySeeder::class,
            ZoneSeeder::class
        ]);

        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'user_id' => $user->id,
            'category_id' => 2
        ]);
        $zone = Zone::first();

        $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicle_id' => $vehicle->id,
            'zone_id'    => $zone->id,
            'hours' => 1
        ]);

        $startTime = (new CarbonImmutable())->setTimeFromTimeString('12:00');
        $stopTime = $startTime->addHour();

        $totalPrice = ParkingPriceService::calculatePrice($zone->id, $vehicle->category_id, $startTime, $stopTime, 1);
        $this->assertEquals(100, $totalPrice);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseCount('parkings', '1');
    }

    public function test_user_parking_correct_price_if_stop_on_free()
    {
        $this->seed([
            CategorySeeder::class,
            ZoneSeeder::class
        ]);

        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'user_id' => $user->id,
            'category_id' => 2
        ]);
        $zone = Zone::first();

        $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicle_id' => $vehicle->id,
            'zone_id'    => $zone->id,
            'hours' => 1
        ]);

        $startTime = (new CarbonImmutable())->setTimeFromTimeString('19:15');
        $stopTime = $startTime->addHour();

        $totalPrice = ParkingPriceService::calculatePrice($zone->id, $vehicle->category_id, $startTime, $stopTime, 1);
        $this->assertEquals(75, $totalPrice);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseCount('parkings', '1');
    }

    public function test_user_parking_correct_price_if_start_on_free()
    {
        $this->seed([
            CategorySeeder::class,
            ZoneSeeder::class
        ]);

        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'user_id' => $user->id,
            'category_id' => 2
        ]);
        $zone = Zone::first();

        $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicle_id' => $vehicle->id,
            'zone_id'    => $zone->id,
            'hours' => 1
        ]);

        $startTime = (new CarbonImmutable())->setTimeFromTimeString('07:45');
        $stopTime = $startTime->addHour();

        $totalPrice = ParkingPriceService::calculatePrice($zone->id, $vehicle->category_id, $startTime, $stopTime, 1);
        $this->assertEquals(75, $totalPrice);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseCount('parkings', '1');
    }
}
