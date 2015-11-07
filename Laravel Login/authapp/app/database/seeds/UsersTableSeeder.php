<?php 

class UsersTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker\Factory::create();
		
		for($i=0; $i <10; $i++)
		{
			$user=User::create(array(
				'email' => $faker->email,
				'username' => $faker->unique->userName,
				'password' => $faker ->word,
				'remember_Token' => str_random(50)
			));
		}
	}
}