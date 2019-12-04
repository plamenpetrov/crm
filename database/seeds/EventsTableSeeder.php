<?php

/*
 * php artisan db:seed --class=EventsTableSeeder
 */

/**
 * Description of ContragentsSeeder
 * 
 * @author PACO
 */
class EventsTableSeeder extends DatabaseSeeder {

    //put your code here

    public function run() {
//        Contragent::truncate();
        
        $faker = new \Faker\Generator();
        
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\DateTime($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));
        $faker->addProvider(new \Faker\Provider\Company($faker));
        $faker->addProvider(new \Faker\Provider\it_IT\Company($faker));

        $faker->addProvider(new \Faker\Provider\en_US\Text($faker));
        $faker->addProvider(new \Faker\Provider\bg_BG\Payment($faker));

        $users = \App\Models\User::all()->pluck('id')->toArray();
                
        foreach (range(1, 10000) as $index) {
            $start = $faker->dateTimeBetween($startDate = '2018-01-01', $endDate = '2019-01-01');
            $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 hours');
            
            Events::create([
                'events_types_id' => $faker->numberBetween(1, 3),
                'events_subtypes_id' => $faker->numberBetween(1, 13),
                'name' => $faker->name,
                'description' =>  $faker->text($maxNbChars = 200),
                'location' =>  $faker->text($maxNbChars = 50),
                'user_id' => $faker->randomElement($users),
                'start_date' => $start,
                'end_date' => $end,
            ]);
        }
    }

}
