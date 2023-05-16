<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAccountAmountRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * @group Auth
 */
class UserAccountAmountController extends Controller
{
    public function update(UserAccountAmountRequest $request)
    {
        auth()->user()->increment('account_amount', $request->account_amount);

        return response()->json($request->user()->only('name', 'email', 'account_amount'));
    }
}
