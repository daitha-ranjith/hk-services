<?php

use App\User;
use App\UserDetail;
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
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@hk.com',
            "password" => bcrypt('admin@hk#123')
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'mobile_no' => 9999999999,
            'address' => 'Admin Address'
        ]);
    }
}
