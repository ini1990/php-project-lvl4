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
        $statuses = collect(['new', 'in work', 'on testing', 'completed']);
        $statuses->each(fn ($item) => \App\TaskStatus::create(['name' => $item]));
    }
}
