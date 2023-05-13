<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Account;
use App\Models\Transaction;

use App\Http\Resources\AccountTransactionResource;
use App\Http\Requests\CreateTransactionRequest;
use AmrShawky\LaravelCurrency\Facade\Currency;

class AccountTransactionController extends Controller
{
    public function index($account_id)
    {
        $transactions = Transaction::where('source_account_id', $account_id)
            ->orWhere('destination_account_id', $account_id)
            ->with(['sourceAccount', 'destinationAccount'])
            ->orderBy('id', 'desc')
            ->paginate(5);

        return response()->json(new AccountTransactionResource($transactions));
    }



    public function store(CreateTransactionRequest  $request)
    {
        $request->validated();

        $destination_account = Account::find(request()->account_number);
        $source_account = Account::find(request()->source_account_number);

        $amount = request()->amount;

        if ($source_account->balance - $amount < 0) {
            $response['message'] = "The given data was invalid";
            $error['amount'] = ["Insufficient funds"];
            $response['errors'] = $error;
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->handleDeposit($destination_account, $source_account, $amount);

        return response()->json("transaction successfull", Response::HTTP_CREATED);
    }



    private function handleDeposit($destination_account, $source_account, $amount)
    {

        $source_account_currency = $source_account->currency;

        $destination_account_currency = $destination_account->currency;

        $convert_currency_amount = Currency::convert()
            ->from($source_account_currency)
            ->to($destination_account_currency)
            ->amount($amount)
            ->get();

        $destination_account_balance = $destination_account->balance;
        $new_destination_balance = $convert_currency_amount + $destination_account_balance;

        $round_off_new_Balance = round($new_destination_balance, 2);

        Account::where('id', $destination_account->id)->update(['balance' => $round_off_new_Balance]);
        Transaction::create([
            'source_account_id' => $source_account->id,
            'destination_account_id' => $destination_account->id,
            'amount' => $amount,
            'currency' => $source_account->currency

        ]);

        $update_source_balance = $source_account->balance - $amount;

        Account::where('id', $source_account->id)->update(['balance' => round($update_source_balance, 2)]);
    }
}
