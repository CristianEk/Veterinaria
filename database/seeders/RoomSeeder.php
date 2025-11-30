<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms =[
            'Sala 1',
            'Sala 2',
            'Sala 3',
            'Sala 4'
        ];
        //
        //Crear los roles
        foreach($rooms as $room){
            Room::create([
                'room_name' => $room,
                'available' => true,
            ]);
    }
    }
}
