<?php

use Illuminate\Database\Seeder;

use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating admin users...');

        $user = new User;
        $user->name = 'Edwin';
        $user->email= "ashtyn54@example.org";
        $user->phone = "4432045899";
        $user->dob = '101595';
        $user->role = 'admin';
        $user->save();

        $user = new User;
        $user->name = 'Christian';
        $user->email= "cj@mail.com";
        $user->phone = "09091965177";
        $user->dob = '121096';
        $user->role = 'admin';
        $user->save();

        $this->command->info('Admin users created');

    }
}
