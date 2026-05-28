<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\AddStudentRequest;
use App\Models\Room;

class StudentController extends Controller
{
   
    public function list(Request $request)
    {
        $students = Student::all();
        return response()->json($students);
    }
    public function add(AddStudentRequest $request)
    {
        $validated=$request->validated();
        $student = Student::create([
            'first_name' => $validated->first_name,
            'last_name'  => $validated->last_name,
            'room_id'    => $validated->room_id,
        ]);

        return response()->json($student);
    }
    public function settle(Request $request, $id)
    {
        $request->validate([
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
        ]);

        $student = Student::findOrFail($id);
        $room = Room::findOrFail($request->room_id);

        if ($student->room_id == $room->id) {
            return response()->json([
                'message' => 'Студент уже в этой комнате',
                'student' => $student
            ]);
        }

        $studentsCount = $room->students()
            ->where('id', '!=', $student->id)
            ->count();

        if ($studentsCount >= $room->capacity) {
            return response()->json([
                'message' => 'В этой комнате больше нет свободных мест'
            ]);
        }

        $student->room_id = $room->id;
        $student->save();

        return response()->json([
            'message' => 'Студент заселен / переселен',
            'student' => $student
        ]);
    }

}