<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
                'category'    => 'Freemium',
                'title'       => 'Freemium',
                'price'       => '0.00',
                'duration'    => 'Infinite',
                'description' => 'Select Sex,Select age,Select distance,Option to show verified profiles only',
                'validity'    => 1 ];
       
        MembershipPlan::create($data);
    }
}
