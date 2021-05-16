<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_name' => $this->faker->name(),
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => $this->faker->country(),
            'latitude' => mt_rand(),
            'longitude' => mt_rand(),
            'phone_no1' => $this->faker->phoneNumber(),
            'phone_no2' => $this->faker->phoneNumber(),
            'zip' => mt_rand(),
            'start_validity' => now(),
            'end_validity' => now()->add('day', 15),
            'status' => Arr::random(['Active', 'Inactive'])
        ];
    }
}
