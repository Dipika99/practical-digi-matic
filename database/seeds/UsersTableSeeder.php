<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$roles = Role::pluck('id')->toArray();

    	factory(App\User::class, 50)->create()->each(function ($user) use ($roles) {
            $rand_key = array_rand($roles);
			$user->roles()->attach([$roles[$rand_key]]);
        });

        //update admin profile picture
        User::whereHas('roles',function($query){
            $query->where('slug','admin');
        })->update(['avatar'=>'avatars/default.png']);

        $admin = User::with('roles')->whereHas('roles',function($query){
            $query->where('slug','admin');
        })->first();

        if($admin){
            dump('admin login credential');
            dump('admin email : '.$admin->email);
            dump('admin password : password');
        }else{
            dump('Run seeder one more time to create admin. ');
        }

    }
}
