<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = Array(
            [
                'name' => 'Andhra Pradesh',
                'country_id' => '1'
            ],
            [
                'name' => 'Arunachal Pradesh',
                'country_id' => '1'
            ],
            [
                'name' => 'Assam',
                'country_id' => '1'
            ],
            [
                'name' => 'Bihar',
                'country_id' => '1'
            ],
            [
                'name' => 'Chhattisgarh',
                'country_id' => '1'
            ]
        );

        foreach($states as $state){
            State::create($state);
        }
    }
}
