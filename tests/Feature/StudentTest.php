<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Student;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_students()
    {
        // Create 5 students using factory
        Student::factory()->count(5)->create();

        $response = $this->getJson('/api/students');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'students' => [
                    '*' => [
                        'id',
                        'firstname',
                        'lastname',
                        'birthdate',
                        'sex',
                        'address',
                        'year',
                        'course',
                        'section',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertJsonCount(5, 'students');
    }

    /** @test */
    public function it_can_create_a_student()
    {
        $studentData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'birthdate' => '2000-01-01',
            'sex' => 'MALE',
            'address' => '123 Main St',
            'year' => 3,
            'course' => 'Computer Science',
            'section' => 'A',
        ];

        $response = $this->postJson('/api/students', $studentData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'student' => $studentData
            ]);

        $this->assertDatabaseHas('students', $studentData);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        // Create a student using factory
        $student = Student::factory()->create();

        $updateData = [
            'firstname' => 'Updated Firstname',
            'lastname' => 'Updated Lastname',
            'birthdate' => '2001-02-02',
            'sex' => 'FEMALE',
            'address' => '456 Elm St',
            'year' => 4,
            'course' => 'Engineering',
            'section' => 'B',
        ];

        $response = $this->patchJson("/api/students/{$student->id}", $updateData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'student' => $updateData
            ]);

        $this->assertDatabaseHas('students', $updateData);
    }
}
