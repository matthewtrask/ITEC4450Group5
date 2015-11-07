<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function($newtable)
	   {
		   $newtable->increments('id');
		   $newtable->string('email')->unique();
		   $newtable->string('fname', 50);
		   $newtable->string('lname', 50);
		   $newtable->string('password', 100);
		   /*Do i need this?
		   * $newtable->rememberToken();
		   * $newtable->timestamps();
		   * NEEDED 
		   * Role: admin or student
		   * Group: Random or grouped
		   * Generated username
		   * Ask about extra files added in laravel 5 
		   * session tables? made a session table php artisan session:table
		   */
	   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
