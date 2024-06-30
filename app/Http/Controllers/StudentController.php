<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Sorting
        if ($request->has('sort')) {
            $sortField = $request->input('sort');
            $query->orderBy($sortField);
        }

        // Searching
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'like', "%$searchTerm%")
                      ->orWhere('lastname', 'like', "%$searchTerm%");
            });
        }

        // Limit and Offset
        $limit = $request->input('limit', 10);
        $query->limit($limit);

        $offset = $request->input('offset', 0);
        $query->offset($offset);

        // Fields
        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            $query->select($fields);
        }

        // Year, Course, Section Filters
        if ($request->has('year')) {
            $year = $request->input('year');
            $query->where('year', $year);
        }

        if ($request->has('course')) {
            $course = $request->input('course');
            $query->where('course', $course);
        }

        if ($request->has('section')) {
            $section = $request->input('section');
            $query->where('section', $section);
        }

        $students = $query->get();

        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'birthdate' => 'required|date_format:Y-m-d',
            'sex' => 'required|in:MALE,FEMALE',
            'address' => 'nullable|string',
            'year' => 'required|integer',
            'course' => 'required|string',
            'section' => 'required|string',
        ]);

        $student = Student::create($validatedData);

        return response()->json(['student' => $student], 201);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);

        return response()->json(['student' => $student]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validatedData = $request->validate([
            'firstname' => 'string',
            'lastname' => 'string',
            'birthdate' => 'date_format:Y-m-d',
            'sex' => 'in:MALE,FEMALE',
            'address' => 'nullable|string',
            'year' => 'integer',
            'course' => 'string',
            'section' => 'string',
        ]);

        $student->update($validatedData);

        return response()->json(['student' => $student]);
    }
}
