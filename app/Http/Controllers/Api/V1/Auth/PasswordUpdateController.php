<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateController extends Controller
{
    public function __invoke(PasswordUpdateRequest $request)
    {
        auth()->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}
