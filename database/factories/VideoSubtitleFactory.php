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
            'lang_id' => $this->faker->numberBetween(1, 4),
            'video_id' => $this->faker->numberBetween(1, 1),
            'name_release' => $this->faker->name,
            'time_start' => $this->faker->unixTime,
            'time_end' => $this->faker->unixTime,
            'created_by' => $this->faker->numberBetween(1, 10),
            'updated_by' => $this->faker->numberBetween(1, 10),
        ];
    }
}
