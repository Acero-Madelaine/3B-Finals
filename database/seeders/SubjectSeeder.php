<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'student_id' => 3,
            'subject_code' => 3,
            'name' => 'Introduction to Computer Science',
            'description' => 'Fundamentals of computer science',
            'instructor' => 'Dr. Smith',
            'schedule' => 'MWF 9:00 AM - 10:00 AM',
            'grades' => json_encode(['prelims' => 85, 'midterms' => 78, 'pre_finals' => 82, 'finals' => 88]),
            'average_grade' => 83.25,
            'remarks' => 'PASSED',
            'date_taken' => '2023-05-15',
        ]);
        
    }
}
