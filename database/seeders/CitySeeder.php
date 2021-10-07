<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = Array(
            [
                'name' => 'Visakhapatnam',
                'state_id' => '1'
            ],
            [
                'name' => 'Vijayawada',
                'state_id' => '1'
            ],
            [
                'name' => '	Guntur',
                'state_id' => '1'
            ],
            [
                'name' => 'Nellore',
                'state_id' => '1'
            ],
            [
                'name' => 'Kurnool',
                'state_id' => '1'
            ],
            [
                'name' => 'Kakinada',
                'state_id' => '1'
            ],
            [
                'name' => '	Rajamahendravaram',
                'state_id' => '1'
            ],
            [
                'name' => '	Kadapa',
                'state_id' => '1'
            ],
            [
                'name' => 'Tirupati',
                'state_id' => '1'
            ],
            [
                'name' => 'Anantapuram',
                'state_id' => '1'
            ],
            [
                'name' => 'Papum Pare',
                'state_id' => '2'
            ],
            [
                'name' => 'Lower Subansiri',
                'state_id' => '2'
            ],
            [
                'name' => 'East Siang',
                'state_id' => '2'
            ],
            [
                'name' => 'Lower Dibang Valley',
                'state_id' => '2'
            ],
            [
                'name' => 'Lohit',
                'state_id' => '2'
            ],
            [
                'name' => 'West Kameng',
                'state_id' => '2'
            ],
            [
                'name' => 'West Siang',
                'state_id' => '2'
            ],
            [
                'name' => 'Dibang Valley',
                'state_id' => '2'
            ],
            [
                'name' => '	Upper Subansiri',
                'state_id' => '2'
            ],
            [
                'name' => 'East Kameng',
                'state_id' => '2'
            ],
            [
                'name' => 'Udalguri',
                'state_id' => '3'
            ],
            [
                'name' => 'Karimganj',
                'state_id' => '3'
            ],
            [
                'name' => 'Cachar',
                'state_id' => '3'
            ],
            [
                'name' => 'Kamrup',
                'state_id' => '3'
            ],
            [
                'name' => 'Kamrup Metro',
                'state_id' => '3'
            ],
            [
                'name' => 'Karbi Anglong',
                'state_id' => '3'
            ],
            [
                'name' => 'Kokrajhar',
                'state_id' => '3'
            ],
            [
                'name' => 'Golaghat',
                'state_id' => '3'
            ],
            [
                'name' => 'Goalpara',
                'state_id' => '3'
            ],
            [
                'name' => 'Chirang',
                'state_id' => '3'
            ],
            [
                'name' => 'Patna',
                'state_id' => '4'
            ],
            [
                'name' => 'Gaya',
                'state_id' => '4'
            ],
            [
                'name' => 'Bhagalpur',
                'state_id' => '4'
            ],
            [
                'name' => 'Muzaffarpur',
                'state_id' => '4'
            ],
            [
                'name' => 'Darbhanga',
                'state_id' => '4'
            ],
            [
                'name' => 'Purnia',
                'state_id' => '4'
            ],
            [
                'name' => 'Bihar Sharif',
                'state_id' => '4'
            ],
            [
                'name' => 'Arrah',
                'state_id' => '4'
            ],
            [
                'name' => 'Begusarai',
                'state_id' => '4'
            ],
            [
                'name' => 'Katihar',
                'state_id' => '4'
            ],
            [
                'name' => 'Ahiwara',
                'state_id' => '5'
            ],
            [
                'name' => 'Akaltara',
                'state_id' => '5'
            ],
            [
                'name' => 'Ambagarh Chowk',
                'state_id' => '5'
            ],
            [
                'name' => 'Ambikapur UA',
                'state_id' => '5'
            ],
            [
                'name' => 'Arang',
                'state_id' => '5'
            ],
            [
                'name' => 'Bade Bacheli',
                'state_id' => '5'
            ],
            [
                'name' => 'Bagbahara',
                'state_id' => '5'
            ],
            [
                'name' => 'Baikunthpur',
                'state_id' => '5'
            ],
            [
                'name' => 'Balod',
                'state_id' => '5'
            ],
            [
                'name' => 'Baloda',
                'state_id' => '5'
            ]
        );

        foreach($cities as $city){
            City::create($city);
        }
    }
}
