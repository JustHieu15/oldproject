<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subjects;
use App\Models\Exams;
use App\Models\Questions;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Use the index method to display a list of exams. / Method: GET / URI: /admin/exams
    public function index()
    {
        $listExams = Exams::all();

        $listSubjects = Subjects::all();

        $listQuestions = Questions::all();

        return view('admin.exams.lists', compact('listExams', 'listSubjects', 'listQuestions'));
    }

    /**
     * Show the form for creating a new resource.
     */

    // Use the create method to display a form for creating a new exam. / Method: GET / URI: /admin/exams/create
    public function create()
    {
        $listSubjects = Subjects::all();

        return view('admin.exams.create', compact('listSubjects'));
    }

    public function createBySubject(string $id)
    {
        $getSubject = Subjects::findOrFail($id);

        return view('admin.exams.createBySubject', compact('getSubject'));
    }

    /**
     * Store a newly created resource in storage.
     */

    // Use the store method to store a newly created exam in the database. / Method: POST / URI: /admin/exams
    public function store(Request $request)
    {
        $data = $request->all();

        $insertExam = Exams::insert([
            'name' => $data['name'],
            'time_limit' => $data['timeLimit'],
            'number_of_questions' => $data['limitQuest'],
            'description' => $data['desc'],
            'subject_id' => $data['subject'],
        ]);

        if ($insertExam) {
            return redirect()->route('admin.exams')->with('success', 'Exam created successfully');
        } else {
            return redirect()->route('admin.exams')->with('error', 'Exam creation failed');
        }
    }

    public function storeBySubject(Request $request, string $id)
    {
        $data = $request->all();

        $insertExam = Exams::insert([
            'name' => $data['name'],
            'time_limit' => $data['timeLimit'],
            'number_of_questions' => $data['limitQuest'],
            'description' => $data['desc'],
            'subject_id' => $id,
        ]);


        if ($insertExam) {
            return redirect()->route('admin.subjects.show', $id)->with('success', 'Exam created successfully');
        } else {
            return redirect()->route('admin.subjects.show', $id)->with('error', 'Exam creation failed');
        }
    }

    /**
     * Display the specified resource.
     */

    // Use the show method to display a specific exam. / Method: GET / URI: /admin/exams/{id}
    public function show(string $id)
    {
        $getExam = Exams::findOrFail($id);

        $listSubjects = Subjects::all();

        $listQuestions = Questions::all();

        $maxQuestions = Questions::where('exam_id', $id)->count();

        return view('admin.exams.show', compact('getExam', 'listSubjects', 'listQuestions', 'maxQuestions'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    // Use the edit method to display a form for editing a specific exam. / Method: GET / URI: /admin/exams/edit/{id}
    public function edit(Request $request, string $id)
    {
        $request->session()->put('id_exam', $id);

        $getExam = Exams::findOrFail($id);

        $getSubject = Subjects::findOrFail($getExam->subject_id);

        return view('admin.exams.edit', compact('getExam', 'getSubject'));
    }

    public function editBySubject(Request $request, string $id)
    {
        $request->session()->put('id_exam', $id);

        $getExam = Exams::findOrFail($id);

        $getSubject = Subjects::findOrFail($getExam->subject_id);

        return view('admin.exams.editBySubject', compact('getExam', 'getSubject'));
    }

    /**
     * Update the specified resource in storage.
     */

    // Use the update method to update a specific exam in the database. / Method: PUT/PATCH / URI: /admin/exams/{id}
    public function update(Request $request)
    {
        $id = session('id_exam');
        $data = $request->all();

        $updateExam = Exams::findOrFail($id)->update([
            'name' => $data['name'],
            'time_limit' => $data['timeLimit'],
            'number_of_questions' => $data['limitQuest'],
            'description' => $data['desc'],
            'subject_id' => $data['subject'],
        ]);

        if ($updateExam) {
            return redirect()->route('admin.exams')->with('success', 'Exam updated successfully');
        } else {
            return redirect()->route('admin.exams')->with('error', 'Exam update failed');
        }
    }

    public function updateBySubject(Request $request)
    {
        $id = session('id_exam');
        $data = $request->all();

        $updateExam = Exams::findOrFail($id)->update([
            'name' => $data['name'],
            'time_limit' => $data['timeLimit'],
            'number_of_questions' => $data['limitQuest'],
            'description' => $data['desc'],
            'subject_id' => $data['subject'],
        ]);

        if ($updateExam) {
            return redirect()->route('admin.subjects.show', [$data['subject']])->with('success', 'Exam updated successfully');
        } else {
            return redirect()->route('admin.subjects.show', [$data['subject']])->with('error', 'Exam update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    // Use the destroy method to delete a specific exam from the database. / Method: DELETE / URI: /admin/exams/{id}
    public function destroy(string $id)
    {
        if (Exams::findOrFail($id)->delete()) {
            return redirect()->route('admin.exams')->with('success', 'Exam deleted successfully');
        } else {
            return redirect()->route('admin.exams')->with('error', 'Exam deletion failed');
        }
    }
}
