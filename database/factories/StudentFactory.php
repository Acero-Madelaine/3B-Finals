<?php

namespace Database\Factories;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'birthdate' => $this->faker->date('Y-m-d', '-18 years'),
            'sex' => $this->faker->randomElement(['MALE', 'FEMALE']),
            'address' => $this->faker->address,
            'year' => $this->faker->numberBetween(1, 4),
            'course' => $this->faker->sentence(2),
            'section' => $this->faker->randomLetter(),
        ];
    }
}
