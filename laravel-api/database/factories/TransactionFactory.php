<?php

namespace Database\Factories;


use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $sourceAccount = \App\Models\Account::factory()->create();
        $destinationAccount = \App\Models\Account::factory()->create([
            'currency' => $sourceAccount->currency,
        ]);

        return [
            'source_account_id' => $sourceAccount->id,
            'destination_account_id' => $destinationAccount->id,
            'amount' => $this->faker->randomFloat(2, 1, $sourceAccount->balance),
            'currency' => $sourceAccount->currency,
        ];
    }
}
