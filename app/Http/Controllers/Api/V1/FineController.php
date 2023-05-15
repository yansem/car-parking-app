<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFineRequest;
use App\Http\Resources\FineResource;
use App\Models\Fine;
use Illuminate\Support\Facades\Request;

/**
 * @group Fines
 */
class FineController extends Controller
{
    public function store(StoreFineRequest $request)
    {
        $fine = Fine::create([$request->validated()]);

        return FineResource::make($fine);
    }
}
