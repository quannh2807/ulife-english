<?php

namespace Database\Factories;

use App\Models\VideoSubtitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoSubtitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VideoSubtitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'video_id' => $this->faker->numberBetween(1, 1),
            'time_start' => $this->faker->unixTime,
            'time_end' => $this->faker->unixTime,
            'vi' => $this->faker->name,
            'en' => $this->faker->name,
            'ko' => $this->faker->name,
            'created_by' => $this->faker->numberBetween(1, 10),
            'updated_by' => $this->faker->numberBetween(1, 10),
        ];
    }
}
