<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subjects;
use App\Models\Exams;
use App\Models\Questions;

class QuestionsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('exam');

        $listExams = Exams::all();

        $listSubjects = Subjects::all();

        $listQuestions = Questions::all();

        return view('admin.questions.lists', compact('listExams', 'listSubjects', 'listQuestions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $listExams = Exams::all();

        return view('admin.questions.create', compact('listExams'));
    }

    public function createByExam(string $id)
    {
        $getExam = Exams::findOrFail($id);

        return view('admin.questions.createByExam', compact('getExam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $insertQuestion = Questions::insert([
            'name' => $data['question'],
            'option_a' => $data['choice1'],
            'option_b' => $data['choice2'],
            'option_c' => $data['choice3'],
            'option_d' => $data['choice4'],
            'correct_answer' => $data['correct'],
            'exam_id' => $data['exam'],
        ]);

        if ($insertQuestion) {
            return redirect()->route('admin.questions')->with('success', 'Question created successfully');
        } else {
            return redirect()->route('admin.questions')->with('error', 'Question created failed');
        }
    }

    public function storeByExam(Request $request, string $id)
    {
        $data = $request->all();

        $insertQuestionByExam = Questions::insert([
            'name' => $data['question'],
            'option_a' => $data['choice1'],
            'option_b' => $data['choice2'],
            'option_c' => $data['choice3'],
            'option_d' => $data['choice4'],
            'correct_answer' => $data['correct'],
            'exam_id' => $id,
        ]);

        if ($insertQuestionByExam) {
            return redirect()->route('admin.exams.show', $id)->with('success', 'Question created successfully');
        } else {
            return redirect()->route('admin.exams.show', $id)->with('error', 'Question created failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getQuestion = Questions::findOrFail($id);

        return view('admin.questions.show', compact('getQuestion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $request->session()->put('id_question', $id);

        $getQuestion = Questions::findOrFail($id);

        $listExams = Exams::all();

        return view('admin.questions.edit', compact('getQuestion', 'listExams'));
    }

    public function editByExam(Request $request, string $id)
    {
        $request->session()->put('id_question', $id);

        $getQuestion = Questions::findOrFail($id);

        $listExams = Exams::all();

        return view('admin.questions.editByExam', compact('getQuestion', 'listExams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = session('id_question');
        $data = $request->all();

        $updateQuestion = Questions::findOrFail($id)->update([
            'name' => $data['question'],
            'option_a' => $data['choice1'],
            'option_b' => $data['choice2'],
            'option_c' => $data['choice3'],
            'option_d' => $data['choice4'],
            'correct_answer' => $data['correct'],
            'exam_id' => $data['exam'],
        ]);

        if ($updateQuestion) {
            return redirect()->route('admin.questions')->with('success', 'Question updated successfully');
        } else {
            return redirect()->route('admin.questions')->with('error', 'Question updated failed');
        }
    }

    public function updateByExam(Request $request)
    {
        $id = session('id_question');
        $data = $request->all();

        $updateQuestionByExam = Questions::findOrFail($id)->update([
            'name' => $data['question'],
            'option_a' => $data['choice1'],
            'option_b' => $data['choice2'],
            'option_c' => $data['choice3'],
            'option_d' => $data['choice4'],
            'correct_answer' => $data['correct'],
            'exam_id' => $data['exam'],
        ]);

        if ($updateQuestionByExam) {
            return redirect()->route('admin.exams.show', [$data['exam']])->with('success', 'Question updated successfully');
        } else {
            return redirect()->route('admin.exams.show', [$data['exam']])->with('error', 'Question updated failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Questions::findOrFail($id)->delete()) {
            return redirect()->route('admin.questions')->with('success', 'Question deleted successfully');
        } else {
            return redirect()->route('admin.questions')->with('error', 'Question deleted failed');
        }
    }

    public function destroyByExam(string $id)
    {

        if (Questions::findOrFail($id)->delete()) {
            return redirect()->back()->with('success', 'Question deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Question deleted failed');
        }
    }
}
