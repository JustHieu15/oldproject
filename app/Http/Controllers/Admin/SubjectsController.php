<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Subjects;
use App\Models\Exams;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Use the index method to display a list of exams. / Method: GET / URI: /admin/exams
    public function index()
    {
        $listSubjects = Subjects::all();

        return view('admin.subjects.lists', compact('listSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */

    // Use the create method to display a form for creating a new exam. / Method: GET / URI: /admin/exams/create
    public function create()
    {
        $listSubjects = Subjects::all();

        return view('admin.subjects.create', compact('listSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     */

    // Use the store method to store a newly created exam in the database. / Method: POST / URI: /admin/exams
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('img')) {
            $file = $request->img;
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $ext;
            $file->storeAs('public', $fileName);
        }

        $data['img'] = $fileName;

        // dd($data);

        $insertSubject = Subjects::insert([
            'name' => $data['name'],
            'description' => $data['detail'],
            'image' => $data['img']
        ]);

        if ($insertSubject) {
            return redirect()->route('admin.subjects')->with('success', 'Subject created successfully');
        } else {
            return redirect()->route('admin.subjects')->with('error', 'Subject created failed');
        }
    }

    /**
     * Display the specified resource.
     */

    // Use the show method to display a specific exam. / Method: GET / URI: /admin/exams/{id}
    public function show(string $id)
    {
        // $getSubject = $this->subjects->getSubjectById($id);

        // $listExams = $this->exams->getAllExams();

        $getSubject = Subjects::findOrFail($id);

        $listExams = Exams::all();

        return view('admin.subjects.show', compact('getSubject', 'listExams'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    // Use the edit method to display a form for editing a specific exam. / Method: GET / URI: /admin/exams/{id}/edit
    public function edit(Request $request, string $id)
    {
        $request->session()->put('id_subject', $id);

        $getSubject = Subjects::findOrFail($id);

        return view('admin.subjects.edit', compact('getSubject'));
    }

    /**
     * Update the specified resource in storage.
     */

    // Use the update method to update a specific exam in the database. / Method: PUT/PATCH / URI: /admin/exams/{id}
    public function update(Request $request)
    {
        $id = session()->has('id_subject') ? session('id_subject') : null;

        if (!$id) {
            return redirect()->route('admin.subjects')->with('error', 'Invalid subject ID');
        }

        $data = $request->all();
        $getSubject = Subjects::findOrFail($id);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $ext;
            $file->storeAs('public', $fileName);
            $data['img'] = $fileName;
        } else {
            $data['img'] = $getSubject->image;
        }

        $updateSubject = Subjects::findOrFail($id)->update([
            'name' => $data['name'],
            'description' => $data['detail'],
            'image' => $data['img']
        ]);


        if ($updateSubject) {
            return redirect()->route('admin.subjects')->with('success', 'Subject updated successfully');
        } else {
            return redirect()->route('admin.subjects')->with('error', 'Subject update failed');
        }
    }


    /**
     * Remove the specified resource from storage.
     */

    // Use the destroy method to delete a specific exam from the database. / Method: DELETE / URI: /admin/exams/{id}
    public function destroy(string $id)
    {
        if (Subjects::findOrFail($id)->delete()) {
            return redirect()->route('admin.subjects')->with('success', 'Subject deleted successfully');
        } else {
            return redirect()->route('admin.subjects')->with('error', 'Subject deleted failed');
        }
    }
}
