<?php

/*
 * php artisan db:seed --class=EventsExecutorsTableSeeder
 */

/**
 * Description of ContragentsSeeder
 * 
 * @author PACO
 */
class EventsExecutorsTableSeeder extends DatabaseSeeder {

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

        $events = Events::all()->pluck('id')->toArray();
        $users = \App\Models\User::all()->pluck('id')->toArray();
                
        foreach (range(1, 10000) as $index) {
            $executors = $faker->numberBetween(1,3);
            
            for($i = 1; $i <= $executors; $i++) {
                EventExecutor::create([
                    'events_id' => $faker->randomElement($events),
                    'executor_id' => $faker->randomElement($users),
                ]);
            }
        }
    }

}
