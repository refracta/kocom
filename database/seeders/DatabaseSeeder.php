<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

         User::factory()->create([
             'name' => 'refracta',
             'nickname' => 'refracta',
             'point' => 99999,
             'permission' => 10,
             'email' => 'refracta@koreatech.ac.kr',
         ]);

        User::factory()->create([
            'name' => 'user1',
            'nickname' => '김코룡',
            'point' => 1000,
            'email' => 'user1@koreatech.ac.kr',
        ]);

        User::factory()->create([
            'name' => 'user2',
            'nickname' => '최코룡',
            'email' => 'user2@koreatech.ac.kr',
        ]);

        User::factory()->create([
            'name' => 'user3',
            'nickname' => '박코룡',
            'email' => 'user3@koreatech.ac.kr',
        ]);

        User::factory()->create([
            'name' => 'user4',
            'nickname' => '이코룡',
            'email' => 'user4@koreatech.ac.kr',
        ]);

        $this->call([BoardSeeder::class, PostSeeder::class]);
    }
}
