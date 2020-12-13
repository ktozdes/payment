<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'amount' => $this->faker->randomFloat(2, $min = 0, $max = 1000000),
            'token' => Str::random(100),
            'full_name' => $this->faker->name,
            'phone' => $this->faker->tollFreePhoneNumber,
            'email' => $this->faker->safeEmail,
            'payed_at' => $this->faker->dateTimeBetween('-2 month'),
            'card_id' => Card::all()->random()->id,
        ];
    }
}
