<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create(['url'=> 'https://proxify.io']);

        Job::create(['url'=> 'https://reddit.com']);

        Job::factory(1000)->create();
    }
}
