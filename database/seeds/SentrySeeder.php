<?php

use Illuminate\Database\Seeder;

class SentrySeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        DB::table('groups')->delete();
        DB::table('users_groups')->delete();

        $user = Sentry::createUser(array(
            'username'   => 'superadmin',
            'password'   => 'ad123min',
            'first_name' => 'Super',
            'last_name'  => 'Administrator',
            'activated'  => 1,
        ));

        $group = Sentry::createGroup(array(
            'name'        => 'Super Administrators',
            'permissions' => array(
                'superuser' => 1
            ),
        ));

        // Assign user permissions
        $userGroup = Sentry::findGroupById(1);
        $user->addGroup($userGroup);
    }

}
