<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $companies = collect([
            ['Role' => '1', 'First' => 'Michael', 'Company' => 'Tall Homes', 'Last' => 'Sanocki', 'email' => 'company1@gmail.com', 'Job' => null],
            ['Role' => '1', 'First' => 'Kyle', 'Company' => 'Kangaroo Homes',  'Last' => 'Stamant', 'email' => 'company2@gmail.com', 'Job' => null],
            ['Role' => '1', 'First' => 'Robert', 'Company' => 'Elephant Homes', 'Last' => 'Vog', 'email' => 'company3@gmail.com', 'Job' => null],
            ['Role' => '2', 'Company' => null, 'First' => 'Taylor', 'Last' => 'Van', 'email' => 'manager1@gmail.com', 'Job' => null],
            ['Role' => '2', 'Company' => null, 'First' => 'Kelly', 'Last' => 'Von', 'email' => 'manager2@gmail.com', 'Job' => null],
            ['Role' => '2', 'Company' => null, 'First' => 'Aaron', 'Last' => 'Ormi', 'email' => 'manager3@gmail.com', 'Job' => null],
            ['Role' => '3', 'Company' => null, 'First' => 'Wess', 'Last' => 'Tea', 'email' => 'supervisor1@gmail.com', 'Job' => null],
            ['Role' => '3', 'Company' => null, 'First' => 'Jesse', 'Last' => 'Ormi', 'email' => 'supervisor2@gmail.com', 'Job' => null],
            ['Role' => '3', 'Company' => null, 'First' => 'Catherine', 'Last' => 'Pow', 'email' => 'supervisor3@gmail.com', 'Job' => null],
            ['Role' => '4', 'Company' => 'PZ Contracting', 'First' => 'Kiyra', 'Last' => 'Chuck', 'email' => 'contractor1@gmail.com', 'Job' => 2],
            ['Role' => '4', 'Company' => 'AB Contracting', 'First' => 'Jack', 'Last' => 'Chin', 'email' => 'contractor2@gmail.com', 'Job' => 3],
            ['Role' => '4', 'Company' => 'Sam Contracting', 'First' => 'Sam', 'Last' => 'Year', 'email' => 'contractor3@gmail.com', 'Job' => 4],
            ['Role' => '4', 'Company' => 'TF Contracting', 'First' => 'Crystal', 'Last' => 'Beach', 'email' => 'contractor4@gmail.com', 'Job' => 5],
            ['Role' => '4', 'Company' => 'DJ Contracting', 'First' => 'Liz', 'Last' => 'Gone', 'email' => 'contractor5@gmail.com', 'Job' => 6],
            ['Role' => '4', 'Company' => 'TP Contracting', 'First' => 'Julek', 'Last' => 'Timber', 'email' => 'contractor6@gmail.com', 'Job' => 7],
            ]);
            
        for($i = 1; $i <= 3; $i++)
        {
            DB::table('tbl_Sites')->insert([
                'OwnerID' => $i,
                'Name' => $faker->city . ' ' . $faker->word,
                'Address' => rand(0,9999) . ' ' . $faker->word . ' ' . $faker->city,
                'Phone' => 905 . rand(0000000,9999999),
                'Photo' => null
            ]);
        }

        for($i = 0; $i < 15; $i++)
        {
        DB::table('Users')->insert([
            'RoleID' => $companies[$i]['Role'],
            'JobID' => $companies[$i]['Job'],
            'Company' => $companies[$i]['Company'],
            'FirstName' => $companies[$i]['First'],
            'LastName' => $companies[$i]['Last'],
            'PhoneNumber' => 905 . rand(0000000,9999999),
            'email' => $companies[$i]['email'],
            'password' => Hash::make('123123'),
        ]);
        }

        for($i = 1; $i <= 3; $i++)
        {
            for($j = 1; $j <= 50; $j++)
            {
                $date = $faker->dateTimeBetween('+1 days', '+2 years')->format('Y-m-d');

                DB::table('tbl_Lots')->insert([
                'SiteID' => $i,
                'StatusID' => rand(1,4),
                'Number' => $j,
                'CompletionDate' => null,
                'DueDate' => $date,
                ]);
            }
        }


        // for($i = 0; $i <= 50; $i++)
        // {
        //     DB::table('Users')->insert([
        //         'RoleID' => rand(1,4),
        //         'JobID' => rand(2,11),
        //         'FirstName' => $faker->name,
        //         'LastName' => $faker->lastName,
        //         'PhoneNumber' => 905 . rand(0000000,9999999),
        //         'email' => $faker->name .'@gmail.com',
        //         'password' => Hash::make('password'),
        //     ]);
        // }

        
    }
}
