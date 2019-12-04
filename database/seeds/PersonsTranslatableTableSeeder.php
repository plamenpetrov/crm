<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContragentsSeeder
 *
 * @author PACO
 */
class PersonsTranslatableTableSeeder extends DatabaseSeeder {

    //put your code here

    public function run() {
//        ContragentTranslatable::truncate();
        
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));
        $faker->addProvider(new \Faker\Provider\Company($faker));
        $faker->addProvider(new \Faker\Provider\it_IT\Company($faker));

        $p = Person::all()->pluck('id')->toArray();

        foreach (range(1, 10000) as $index) {
            PersonTranslatable::create([
                'persons_id' => $faker->randomElement($p),
                'first_name' => $faker->name,
                'family_name' => $faker->name,
                'address_idcard' => $faker->streetAddress,
                'mailing_address' => $faker->streetAddress,
                'lang' => $faker->numberBetween(1, 2),
            ]);
        }
    }

}
