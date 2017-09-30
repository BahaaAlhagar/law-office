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
		});
    }
}
