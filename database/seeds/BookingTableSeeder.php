<?php


use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingTableSeeder  extends Seeder
{
    public function run()
    {
        factory(Booking::class, 20)->create();
    }
}
