<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed for admin user when installing
    	$admin = new \App\User();

    	$admin->name = 'الادارة';
    	$admin->email = 'admin@law.dev';
    	$admin->password = bcrypt('secret');
    	$admin->group_id = 5;
    	$admin->remember_token = str_random(30);
    	$admin->save();



    	// old seeds
/*
        // $this->call(UsersTableSeeder::class);
        // Populate roles
		factory(App\Person::class, 20)->create();

		// Populate users
		factory(App\Contract::class, 50)->create();

		// Get all the people attaching up to 3 random contracts to each person
		$people = App\Person::all();

		// Populate the pivot table
		App\Contract::all()->each(function ($contract) use ($people) { 
		    $contract->people()->attach(
		        $people->random(rand(1, 3))->pluck('id')->toArray()
		    );
		});*/
    }
}
