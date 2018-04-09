<?php

use App\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_encode(new stdClass);

        Service::insert([
            ['name' => 'video', 'active' => 1, 'settings' => $json],
            ['name' => 'chat', 'active' => 1, 'settings' => $json],
            ['name' => 'sms', 'active' => 1, 'settings' => $json],
            ['name' => 'email', 'active' => 1, 'settings' => $json]
        ]);
    }
}
