<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

use App\Models\User;
use App\Models\Account;

class UserAcountsController extends Controller
{
    public function index()
    {
        $userAccounts = User::with('account')->get();

        return response()->json($userAccounts, Response::HTTP_OK);
    }

    public function show($account_id)
    {
        $userAcount = Account::where('id', $account_id)->with('user')->get();
        return response()->json($userAcount, Response::HTTP_OK);
    }
}
