<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tasks = ["Wash Car", "Wash Dish", "Collect Garbage", "Do Homework"];
        for ($i = 0; $i < count($tasks); $i++) {
            DB::table('todos')->insert([
                'task' => $tasks[$i],
                'created_at' => Carbon::now()
            ]);
        }
    }
}
