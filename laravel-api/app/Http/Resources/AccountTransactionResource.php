<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AccountTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactions = [];

        foreach ($this->resource as $transaction) {


            $transactions[] = [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'currency' => $transaction->sourceAccount->currency,
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', $transaction->created_at)->format('m/d/Y'),
                'source_account' => [
                    'account_id' => $transaction->sourceAccount->id,
                    'user_id' => $transaction->sourceAccount->user_id,
                ],
                'destination_account' => [
                    'account_id' => $transaction->destinationAccount->id,
                    'user_id' => $transaction->destinationAccount->user_id,
                ],
                'type' => $transaction->source_account_id == $request->account_id ? 'Debit' : 'Credit'
            ];
        }

        return [
            'data' => $transactions,
            'links' => [
                'self' => $this->url($this->currentPage()),
                'next' => $this->nextPageUrl(),
                'prev' => $this->previousPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
        ];
    }
}
