<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teams = Team::all();

        return [
            'title' => $this->faker->word . ' Project',
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['not_started', 'in_progress', 'completed', 'on_hold']),
            'due_date' => $this->faker->dateTimeBetween('now', '+2 months'),
            'team_id' => $teams->random()->id,
        ];
    }
}
