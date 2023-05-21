<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkingStoreRequest;
use App\Http\Requests\ParkingUpdateRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Models\Vehicle;
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
                'errors' => ['general' => ['Нельзя припарковать одну и туже машину дважды. Оставновите текущую парковку.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parkingData['start_time'] = now();
        $parkingData['stop_time'] = $parkingData['start_time']->copy()->addHours($parkingData['hours']);
        $vehicle = Vehicle::find($parkingData['vehicle_id']);
        $parkingData['total_price'] = ParkingPriceService::calculatePrice(
            $parkingData['zone_id'],
            $vehicle->category_id,
            $parkingData['start_time'],
            $parkingData['stop_time'],
            $parkingData['hours']
        );

        if ($parkingData['total_price'] === 0) {
            return response()->json(['successes' => ['general' => ['Парковка бесплатная!']]]);
        }

        if (auth()->user()->account_amount < $parkingData['total_price']) {
            return response()->json(['errors' => ['general' => ['Недостаточно средств на счете']]],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($parkingData);

        return ParkingResource::make($parking);
    }

    public function update(ParkingUpdateRequest $parkingUpdateRequest, Parking $parking)
    {
        auth()->user()->decrement('account_amount', auth()->user()->total_price);
        $parking->update(['paid' => true]);

        return ParkingResource::make($parking);
    }

    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }
}
