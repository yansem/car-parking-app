<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Zone;
use Carbon\Carbon;

class ParkingPriceService
{
    public static function calculatePrice(int $zone_id, int $category_id, string $startTime, string $stopTime): int
    {
        $start = new Carbon($startTime);
        $stop = new Carbon($stopTime);

        $totalTimeByMinutes = $stop->diffInMinutes($start);

        $priceByMinutes = (Zone::find($zone_id)->rate * Category::find($category_id)->price) / 60;

        return ceil($totalTimeByMinutes * $priceByMinutes);
    }
}