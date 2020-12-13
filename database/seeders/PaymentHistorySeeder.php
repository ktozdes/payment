<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\PaymentHistory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class PaymentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPayments = Payment::all();
        foreach ($allPayments as $singlePayment) {
            $historyCount = rand(0, 3);
            if ($historyCount > 0) {
                PaymentHistory::factory()
                ->count($historyCount)
                ->state(new Sequence(
                    ['status_id' => 1],
                    ['status_id' => 2],
                    ['status_id' => 3],
                ))
                ->create([
                    'payment_id' => $singlePayment->id,
                ]);
            }
        }

    }
}
