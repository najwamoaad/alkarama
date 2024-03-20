<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Information;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Information>
 */
class InformationFactory extends Factory
{  protected $model = Information::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('ar_EG');

        return [
            'uuid' => Uuid::uuid4()->toString(),
            'title' => $faker->sentence,
            'content' => $faker->paragraph,
            'image' => $faker->imageUrl,
            'type' => $faker->randomElement(['strategy', 'news', 'regular','slider']),
            'reads' => $faker->numberBetween(0, 100),
            'infoable_type' =>$faker->randomElement(['App\Models\Club', 'App\Models\Matche', 'App\Models\Seasone']),
            'infoable_id' => $faker->numberBetween(1, 4),
        ];
    }
}
