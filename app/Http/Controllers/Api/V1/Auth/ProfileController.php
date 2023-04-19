<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user()->only('name', 'email'));
    }

    public function update(ProfileRequest $request)
    {
        $validatedData = $request->validated();

        auth()->user()->update($validatedData);

        return response()->json($validatedData, Response::HTTP_ACCEPTED);
    }
}
