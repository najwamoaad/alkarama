<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Information;
class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Information::factory()
        ->count(5)
        ->create()
        ->each(function ($information) {
            $infoableType = $this->getRandomInfoableType();
            $infoable = $infoableType::inRandomOrder()->first();

            $information->infoable()->associate($infoable);
            $information->save();
        });
    }
    private function getRandomInfoableType()
    {
        // قائمة النماذج الممكنة التي يمكن أن تكون لها علاقة infoable
        $infoableTypes = [
            'App\Models\Club',
            'App\Models\Matche',
            'App\Models\Seasone'
        ];

        return $infoableTypes[array_rand($infoableTypes)];
    }
}
