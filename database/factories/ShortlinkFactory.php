<?php

namespace Database\Factories;

use App\Models\Shortlink;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortlinkFacotry extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shortlink::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }

}
