<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getItems() as $item) {
            Position::create(
                [
                    'name' => $item
                ]
            );
        }
    }

    protected function getItems()
    {
        return [
            'PHP Developer',
            'Ruby Developer',
            'UI/UX Designer',
            'Sales Manager',
            'Project Manager',
            'Front-end Developer',
            'CEO',
            'CTO',
        ];
    }
}
