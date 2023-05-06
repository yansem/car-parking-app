<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkingStoreRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Category;
use App\Models\Parking;
use App\Models\Vehicle;
use App\Models\Zone;
use App\Services\ParkingPriceService;
use Illuminate\Http\Response;

/**
 * @group Parking
 */
class ParkingController extends Controller
{
    public function store(ParkingStoreRequest $request)
    {
        $parkingData = $request->validated();

        if (Parking::active()->where('vehicle_id', $parkingData['vehicle_id'])->exists()) {
            return response()->json([
                'errors' => ['general' => ['Can\'t start parking twice using same vehicle. Please stop currently active parking.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $parkingData['start_time'] = now();
        $parkingData['stop_time'] = $parkingData['start_time']->copy()->addHours($parkingData['hours']);
        $vehicle = Vehicle::find($parkingData['vehicle_id']);
//        $parkingData['total_price'] = ParkingPriceService::calculatePrice($parkingData['zone_id'], $vehicle->category_id, $parkingData['start_time'], $parkingData['stop_time']);
        $parkingData['total_price'] = Zone::find($parkingData['zone_id'])->rate * Category::find($vehicle->category_id)->price_per_hour * $parkingData['hours'];
        $parking = Parking::create($parkingData);

        return ParkingResource::make($parking);
    }

    public function update(Parking $parking)
    {
        $parking->update(['paid' => true]);

        return ParkingResource::make($parking);
    }

    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }
}
