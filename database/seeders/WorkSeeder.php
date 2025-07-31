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
    public function run(): void
    {
        $user = User::first(); // 1人目のユーザーに紐付け（必須）

        if (!$user) {
            $user = User::factory()->create([ // ユーザーがいない場合は新規作成
                'name' => 'テストユーザー',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $works = [
            [
                'work_date' => '2025-07-31',
                'weather' => '晴れ',
                'crops' => '大根',
                'work_details' => '草刈り',
                'work_time' => 120,
                'content' => '畑の外周の草刈りを実施',
            ],
            [
                'work_date' => '2025-07-28',
                'weather' => '曇り',
                'crops' => 'キャベツ',
                'work_details' => '播種',
                'work_time' => 90,
                'content' => '苗ポットに播種作業を行なった',
            ],
            [
                'work_date' => '2025-07-25',
                'weather' => '雨',
                'crops' => 'トマト',
                'work_details' => '施肥',
                'work_time' => 60,
                'content' => '元肥として堆肥を投入',
            ],
        ];

        foreach ($works as $work) {
            Work::create(array_merge($work, [
                'user_id' => $user->id, // ユーザーIDを設定
                'image_path' => null, // 画像はなし
            ]));
        }

        // ✅ Factoryを使って追加で10件作成
        Work::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);
    }
}
