<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AllergySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(SeedAdminRoleAndUser::class);
        // $this->call(GrantAllPermsToAdmin::class);

        // $this->call(AllergySeeder::class);
        $this->call(PatientScaleSeeder::class);
    }
}
