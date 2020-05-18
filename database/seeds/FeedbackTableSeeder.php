<?php


use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackTableSeeder extends Seeder
{
    public function run()
    {
        factory(Feedback::class, 10)->create();
    }
}
