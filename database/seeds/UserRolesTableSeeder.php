<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('adminroles')->delete();

        \DB::table('adminroles')->insert([
            0 => [
                'role_id' => 1,
                'user_id' => 1,
            ],
            1 => [
                'role_id' => 2,
                'user_id' => 1,
            ],
        ]);
    }
}
