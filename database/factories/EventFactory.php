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
            'description' => $this->faker->paragraph(),
            'start_time' => $now->format('Y-m-d H:i:s'),
            'end_time' => $now->addDays(rand(0, 1))->addHours(rand(1, 5))->format('Y-m-d H:i:s'),
            'color' => $this->faker->hexColor, // Genera un colore casuale
            'title' => $this->faker->randomElement([
                'Conferenza Tech 2025', 'Workshop di Leadership', 'Incontro Aziendale',
                'Corso di Formazione', 'Evento di Networking', 'Webinar sul Digital Marketing',
                'Masterclass in Project Management', 'Forum sull’Innovazione', 'Pitch Startup Competition',
                'Hackathon Laravel', 'Bootcamp di Programmazione', 'Conferenza su AI e Machine Learning',
                'Workshop di Cybersecurity', 'Seminario su Cloud Computing', 'Talk su Blockchain e NFT',
                'Evento DevOps', 'Corso su Docker e Kubernetes', 'Coding Challenge 2025',
                'Seminario Universitario', 'Workshop di Public Speaking', 'Lezione su Finanza Personale',
                'Masterclass di Scrittura Creativa', 'Corso di Psicologia Applicata', 'Workshop di Fotografia',
                'Lezione su Astronomia', 'Corso di Disegno Digitale', 'Evento TEDx',
            ]),
        ];
    }
}
