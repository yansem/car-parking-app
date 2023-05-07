<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Parking;
use App\Models\Zone;
use Carbon\Carbon;

class ParkingPriceService
{
    public static function calculatePrice(int $zone_id, int $category_id, string $startTime, string $stopTime, int $hours): int
    {
        $start = new Carbon($startTime);
        $stop = new Carbon($stopTime);

        $start_paid = new Carbon(Parking::START_PAID_PARKING);
        $end_paid = new Carbon(Parking::END_PAID_PARKING);

        $start_free = new Carbon(Parking::START_FREE_PARKING);
        $end_free = new Carbon(Parking::END_FREE_PARKING);

        if ($stop->gte($start_free)) {
            $hours = $start->diffInMinutes($end_paid) / 60;
        }
        elseif ($start->lte($end_free)) {
            $hours = $start_paid->diffInMinutes($stop) / 60;
        }

        return ceil(Zone::find($zone_id)->rate * Category::find($category_id)->price_per_hour * $hours);
    }
}