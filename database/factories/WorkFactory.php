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

    public function definition(): array
    {
        // faker日本語化
        $faker = \Faker\Factory::create('ja_JP');

        $cropsList = [
            'トマト', '大根', 'キャベツ', 'ピーマン', 'にんじん'
        ];
        $workDetailsList = [
            '草刈り', '播種', '収穫', '施肥', '整枝', 'みず'
        ];
        $weatherList = [
            '晴れ', '曇り', '雨', '雪'
        ];

        return [
            'user_id' => 1,
            'crops' => $this->faker->randomElement($cropsList),
            'work_details' => $this->faker->randomElement($workDetailsList),
            'work_time' => $this->faker->numberBetween(30, 300),
            'work_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'content' => $this->faker->realText(50),
            'weather' => $this->faker->randomElement($weatherList),
            'image_path' => null, // 画像はなし
        ];
    }
}
