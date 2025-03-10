<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'root@root.com'],
            [
                'name' => 'Root User',
                'password' => Hash::make('root'), // Imposta la password 'root' (Hashed)
            ]
        );
        Event::factory()->count(20)->create();
    }
}
