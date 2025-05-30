<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Work;
use App\Models\User;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Work::class;

    public function definition()
    {
        // faker日本語化
        $faker = \Faker\Factory::create('ja_JP');

        return [
            'user_id' => User::factory(),
            'title' => $faker->realText(30),
            'category_name' => $faker->randomElement([
                'トマト',
                'きゅうり',
                'ナス',
                'だいこん',
                'レタス',
                'キャベツ',
                'ほうれん草',
                'ピーマン',
                'いちご',
                '米',
                '桜葉',
                'その他',
            ]),
            'work_time' => $faker->numberBetween(30, 300),
            'content' => $faker->randomElement([
                'トマトの苗を一本ずつ植え付けました。暑かったので水やりをしっかりしました。',
                'キャベツの間引きを行い、健康な苗だけを残しました。',
                'きゅうりの実を早朝に収穫しました。サイズも色も良好です。',
                'ナスの摘果作業をして、今後の成長を促進させました。',
                'だいこんの種まきを終えました。来週には発芽予定です。',
            ]),
            'work_date' => $faker->date('Y-m-d'),
        ];
    }
}
