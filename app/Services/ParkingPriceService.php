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

        if ($start->between('00:00', Parking::END_FREE_PARKING)) {
            $start_free = (new Carbon(Parking::START_FREE_PARKING))->subDay();
            $end_free = (new Carbon(Parking::END_FREE_PARKING));
            $start_paid = new Carbon(Parking::START_PAID_PARKING);
        } else {
            $start_free = new Carbon(Parking::START_FREE_PARKING);
            $end_free = (new Carbon(Parking::END_FREE_PARKING))->addDay();
            $start_paid = (new Carbon(Parking::START_PAID_PARKING))->addDay();
        }
        $end_paid = (new Carbon(Parking::END_PAID_PARKING));

        if (!$start->between($start_free, $end_free) && $stop->between($start_free, $end_free)) {
            $hours = $start->diffInMinutes($end_paid) / 60;
        }
        elseif ($start->between($start_free, $end_free) && !$stop->between($start_free, $end_free)) {
            $hours = $start_paid->diffInMinutes($stop) / 60;
        }
        elseif ($start->between($start_free, $end_free) && $stop->between($start_free, $end_free)) {
            return 0;
        }

        return ceil(Zone::find($zone_id)->rate * Category::find($category_id)->price_per_hour * $hours);
    }
}