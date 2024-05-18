<?php

namespace App\Http\Controllers\Client;

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

    public function index()
    {
        $listSubjects = Subjects::all();

        $listExams = Exams::all();

        $listQuestions = Questions::all();

        return view('clients.exams.lists', compact('listSubjects', 'listExams', 'listQuestions'));
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $listSubjects = Subjects::all();

        $getExam = Exams::findOrFail($id);

        $listQuestions = Questions::all();

        return view('clients.exams.show', compact('listSubjects', 'getExam', 'listQuestions'));
    }
}
