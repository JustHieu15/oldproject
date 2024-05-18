<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subjects;
use App\Models\Exams;
use App\Models\Questions;
use App\Models\User;
use App\Models\UsersExams;

class QuestionsController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getExam = Exams::findOrFail($id);

        $listQuestions = Questions::all();

        $timeLimit = $getExam->time_limit;
        foreach ($listQuestions as $question) {
            if ($getExam->id == $question->exam_id) {
                $countdown = $timeLimit * 60;
            }
        }

        return view('clients.questions.show', compact('getExam', 'listQuestions', 'countdown'));
    }

    public function completeExam(Request $request, string $examId, string $userId)
    {
        $answers = $request->all();

        $getExam = Exams::findOrFail($examId);

        $listQuestions = Questions::all();

        $userAnswers = $answers['answers'];

        $point = 0;

        $limitQuest = $getExam->number_of_questions;

        foreach ($listQuestions as $question) {
            if ($getExam->id == $question->exam_id) {
                foreach ($userAnswers as $key => $userAnswer) {
                    if ($question->id == $key) {
                        if ($question->correct_answer == $userAnswer) {
                            $point++;
                        }
                    }
                }
            }
        }

        $point = $point / $limitQuest * 10;

        User::join('users_exams', 'users.id', '=', 'users_exams.user_id')
            ->where('users_exams.user_id', $userId)
            ->where('users_exams.exam_id', $examId)
            ->first();

        UsersExams::insert([
            'user_id' => $userId,
            'exam_id' => $examId,
            'score' => $point,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('questions.result', [$examId, $userId])->withoutHeader('Referer');
    }

    public function result(string $examId, string $userId)
    {

        $getExam = Exams::findOrFail($examId);

        $getUserScore = User::join('users_exams', 'users.id', '=', 'users_exams.user_id')
            ->where('users_exams.user_id', $userId)
            ->where('users_exams.exam_id', $examId)
            ->orderBy('users_exams.created_at', 'desc')
            ->first();

        return view('clients.questions.result', compact('getExam', 'getUserScore'));
    }
}
