<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\StrategicObjective;

class StrategicObjectivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getItems() as $item) {
            StrategicObjective::create(
                [
                    'name' => $item
                ]
            );
        }
    }

    protected function getItems()
    {
        return [
            'Expertise in technology',
            'Expertise in the sphere',
            'Other',
        ];
    }
}
