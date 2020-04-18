<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = 
        [
    		[
	        	'name'=>'Admin',
	        	'slug'=>'admin',
	        	'description'=>'This is admin role.',
        	],[
	        	'name'=>'Vendor',
	        	'slug'=>'vendor',
	        	'description'=>'This is venor role.',
        	],[
	        	'name'=>'Customer',
	        	'slug'=>'customer',
	        	'description'=>'This is customer role.',
        	],
    	];
    	foreach ($roles as $data) {
	    	Role::create($data);
    	}
    }
}
