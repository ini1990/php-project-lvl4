<?php

use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['new', 'in work', 'on testing', 'completed'])
        ->each(fn ($status) => \App\TaskStatus::create(['name' => $status]));
    }
}
