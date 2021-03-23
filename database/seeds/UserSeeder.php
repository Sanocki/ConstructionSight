<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        error_log($faker->firstname);
        // DB::table('Users')->insert([
        //     'RoleID' => 1,
        //     'JobID' => null,
        //     'Name' => "Michael Sanocki",
        //     'PhoneNumber' => 905 . rand(0000000,9999999),
        //     'email' => 'sanockimike@gmail.com',
        //     'password' => Hash::make('123123'),
        // ]);
        // for($i = 1; $i <= 50; $i++)
        // {
        //     DB::table('Users')->insert([
        //         'RoleID' => 4,
        //         'JobID' => rand(2,11),
        //         'Company' => $faker->lexify('??') . ' Contracting',
        //         'FirstName' => $faker->firstname,
        //         'LastName' => $faker->lastName,
        //         'PhoneNumber' => 905 . rand(0000000,9999999),
        //         'email' => 'Contractor' . ($i+6) .'@gmail.com',
        //         'password' => Hash::make('123123'),
        //     ]);
        // }

        for($i = 16; $i <= 65; $i++)
        {
            DB::table('tbl_SiteApproval')->insert([
                'SiteID' => 1,
                'UserID' => $i,
                'Status' => 0,
            ]);
        }
    }
}
