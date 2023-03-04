<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'body' => $this->faker->paragraph(2),
            'slug' => Str::slug($title),
            'channel_id' => function() {
                return Channel::factory()->create()->id;
            },
            'user_id' => function() {
                return User::factory()->create()->id;
            }
        ];
    }
}
