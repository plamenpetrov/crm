<?php

/*
 * php artisan db:seed --class=ContragentsTableSeeder
 */

/**
 * Description of ContragentsSeeder
 *
 * @author PACO
 */
class ContragentsTableSeeder extends DatabaseSeeder {

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

        $users = \App\Models\User::all()->pluck('id')->toArray();
                
        foreach (range(1, 10000) as $index) {
            Contragent::create([
                'EIK' => $faker->vat(false),
                'DanNom' => $faker->vat(false),
                'settlements_id' => $faker->numberBetween(1, 5000),
                'country_id' => $faker->numberBetween(1, 245),
                'company_organization_types_id' => $faker->numberBetween(1, 2),
                'company_types_id' => $faker->numberBetween(1, 8),
                'email' => $faker->email,
                'phone' => $faker->tollFreePhoneNumber,
                'user_id' => $faker->randomElement($users),
            ]);
        }
    }

}
