<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseAnswerController extends Controller
{
    public function store(Request $request, $exercise_id)
    {
        $user = Auth::user();
        $exercise = Exercise::find($exercise_id);

        if (!$exercise) {
            return response()->json(['message' => 'التمرين غير موجود ❌'], 404);
        }

        // تحقق أن الطالب داخل بالكورس
        $course = $exercise->course;
        if (!$course->students->contains($user->id)) {
            return response()->json(['message' => 'غير مصرح لك بالإجابة على هذا التمرين ❌'], 403);
        }

        $data = $request->validate([
            'answer' => 'required|string',
        ]);

        // ✅ منطق التصحيح حسب نوع التمرين
        $isCorrect = false;

        if ($exercise->type === 'true_false') {
            $isCorrect = strtolower(trim($data['answer'])) === strtolower(trim($exercise->correct_answer));
        } elseif ($exercise->type === 'multiple_choice') {
            $isCorrect = $data['answer'] === $exercise->correct_answer;
        }

        // 💾 حفظ الإجابة
        $answer = ExerciseAnswer::create([
            'exercise_id' => $exercise->id,
            'student_id' => $user->id,
            'answer' => $data['answer'],
            'is_correct' => $isCorrect,
        ]);

        return response()->json([
            'message' => $isCorrect ? 'إجابة صحيحة ✅' : 'إجابة خاطئة ❌',
            'result' => $answer,
        ]);
    }
}

