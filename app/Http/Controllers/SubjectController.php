<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SubjectController extends Controller
{
    public function index2(Request $request, $studentId)
    {
  
        $query = Subject::where('student_id', $studentId);

 
        if ($request->has('sort')) {
            $sortField = $request->input('sort');
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('subject_code', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('limit')) {
            $limit = $request->input('limit');
            $query->take($limit);
        }

        if ($request->has('offset')) {
            $offset = $request->input('offset');
            $query->skip($offset);
        }

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            $query->select($fields);
        }

     
        $subjects = $query->get();

        
        foreach ($subjects as $subject) {
            $subject->remarks = $subject->average_grade >= 3.0 ? 'PASSED' : 'FAILED';
        }

        return response()->json($subjects);
    }

    public function store2(Request $request, $studentId)
    {
        $request->validate([
            'subject_code' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'instructor' => 'required|string',
            'schedule' => 'required|string',
            'grades' => 'array',
            'grades.prelims' => 'nullable|numeric',
            'grades.midterms' => 'nullable|numeric',
            'grades.pre_finals' => 'nullable|numeric',
            'grades.finals' => 'nullable|numeric',
            'average_grade' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'date_taken' => 'required|date_format:Y-m-d',
        ]);

        $subject = Subject::create([
            'student_id' => $studentId,
            'subject_code' => $request->subject_code,
            'name' => $request->name,
            'description' => $request->description,
            'instructor' => $request->instructor,
            'schedule' => $request->schedule,
            'grades' => $request->grades,
            'average_grade' => $request->average_grade,
            'remarks' => $request->remarks,
            'date_taken' => $request->date_taken,
        ]);

        return response()->json($subject, 201);
    }

    public function show2($studentId, $subjectId)
    {
        $subject = Subject::findOrFail($subjectId);

        return response()->json($subject);
    }

    public function update2(Request $request, $studentId, $subjectId)
    {
        $request->validate([
            'subject_code' => 'string',
            'name' => 'string',
            'description' => 'string',
            'instructor' => 'string',
            'schedule' => 'string',
            'grades' => 'array',
            'grades.prelims' => 'nullable|numeric',
            'grades.midterms' => 'nullable|numeric',
            'grades.pre_finals' => 'nullable|numeric',
            'grades.finals' => 'nullable|numeric',
            'average_grade' => 'nullable|numeric',
            'remarks' => 'string',
            'date_taken' => 'date_format:Y-m-d',
        ]);

        $subject = Subject::findOrFail($subjectId);
        $subject->update($request->all());

        return response()->json($subject, 200);
    }
}
