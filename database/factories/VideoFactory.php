<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ytb_id' => '7wtfhZwyrcc',
            'cate_id' => $this->faker->numberBetween(1, 50),
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 100),
            'ytb_thumbnails' => '"default":{"url":"https://i.ytimg.com/vi/7wtfhZwyrcc/default.jpg","width": 120,"height": 90},"medium":{"url": "https://i.ytimg.com/vi/7wtfhZwyrcc/mqdefault.jpg","width": 320,"height": 180},"high":{"url":"https://i.ytimg.com/vi/7wtfhZwyrcc/hqdefault.jpg","width": 480,"height": 360},"standard":{"url": "https://i.ytimg.com/vi/7wtfhZwyrcc/sddefault.jpg","width": 640,"height": 480},"maxres":{"url": "https://i.ytimg.com/vi/7wtfhZwyrcc/maxresdefault.jpg","width": 1280,"height": 720}',
            'publish_at' => $this->faker->unixTime($max = 'now'),
            'tags' => '["Imagine","Dragons","Believer","KIDinaKORNER/Interscope","Records","Alternative","Imagine Dragons","Dan Reynolds","Believer. Nintendo","Nintendo Switch","Radioactive","Night Visions","Demons","It’s Time","Bet My Life","Dolph Lundgren","Smoke + mirrors","Sucker For Pain","On Top of The World"]',
            'author' => $this->faker->userName,
            'channel_id' => 'UCpx_k19S2vUutWUUM9qmXEg',
            'channel_title' => $this->faker->name(),
            'created_by' => $this->faker->numberBetween(1, 10),
            'updated_by' => $this->faker->numberBetween(1, 10),
        ];
    }
}
