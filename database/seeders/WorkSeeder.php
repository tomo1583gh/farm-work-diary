<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Work;
use App\Models\User;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ① まずユーザーを5人作る
        $users = User::factory()->count(5)->create();

        // ② 各ユーザーに6件ずつ作業（Work）を作成（5人×6件＝30件）
        foreach ($users as $user) {
            Work::factory()
                ->count(6)
                ->create([
                    'user_id' => $user->id, // ユーザーごとに紐づける
                ]);
            }
    }
}
