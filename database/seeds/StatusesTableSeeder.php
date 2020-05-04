<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getItems() as $item) {
            Status::create(
                [
                    'name' => $item['name'],
                    'slug' => $item['slug']
                ]
            );
        }
    }

    protected function getItems()
    {
        return [
            [
                'name' => 'Active',
                'slug' => Status::SLUG_ACTIVE
            ],
            [
                'name' => 'Completed',
                'slug' => Status::SLUG_COMPLETED
            ],
            [
                'name' => 'Paused',
                'slug' => Status::SLUG_FROZEN
            ],
            [
                'name' => 'Rejected',
                'slug' => Status::SLUG_REJECTED
            ],
        ];
    }
}
