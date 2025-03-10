<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = \App\Models\Event::class;
    public function definition()
    {
        $now=Carbon::now()->addDays(rand(1, 30))->addHours(rand(1,24));
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id, // Assegna un utente esistente o ne crea uno nuovo
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_time' => $now->format('Y-m-d H:i:s'),
            'end_time' => $now->addDays(rand(0, 1))->addHours(rand(1, 5))->format('Y-m-d H:i:s'),
            'color' => $this->faker->hexColor, // Genera un colore casuale
        ];
    }
}
