<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\OperationalGoal;

class OperationGoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getItems() as $item) {
            OperationalGoal::create(
                [
                    'name' => $item
                ]
            );
        }
    }

    protected function getItems()
    {
        return [
            'Joining the High Technologies Park',
            'Client satisfaction',
            'Staff satisfaction',
            'Other',
        ];
    }
}
