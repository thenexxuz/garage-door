<?php

namespace Database\Seeders;

use App\Models\GarageDoor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GarageDoorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $garageDoor = new GarageDoor();
        $garageDoor->name = 'Garage Door';
        $garageDoor->save();
    }
}
