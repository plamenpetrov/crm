<?php

/*
 * php artisan db:seed --class=ContragentsTableSeeder
 */

/**
 * Description of ContragentsSeeder
 *
 * @author PACO
 */
class PersonsTableSeeder extends DatabaseSeeder {

    //put your code here

    public function run() {
//        Contragent::truncate();
        
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));
        $faker->addProvider(new \Faker\Provider\Company($faker));
        $faker->addProvider(new \Faker\Provider\it_IT\Company($faker));

        $faker->addProvider(new \Faker\Provider\en_US\Text($faker));
        $faker->addProvider(new \Faker\Provider\bg_BG\Payment($faker));

        $faker->addProvider(new \Faker\Provider\Barcode($faker));
        $faker->addProvider(new \Faker\Provider\DateTime($faker));
        
        
        $users = \App\Models\User::all()->pluck('id')->toArray();
                
        foreach (range(1, 10000) as $index) {
            Person::create([
                'identification_number' => $faker->isbn10,
                'email' => $faker->email,
                'phone' => $faker->tollFreePhoneNumber,
                'idcard' => $faker->isbn10, 
                'idcard_date_of_issue' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'idcard_date_of_expiry' => $faker->dateTimeBetween($startDate = 'now', $endDate = '2050-01-01', $timezone = null),
                'user_id' => $faker->randomElement($users),
                'published_by' => $faker->numberBetween(1, 5000)
            ]);
        }
    }

}
