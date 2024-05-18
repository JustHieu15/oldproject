<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Subjects;
use App\Models\Exams;
use App\Models\User;
use App\Models\UsersSubjects;

class SubjectsController extends Controller
{
    public function index()
    {
        return view('client.subjects.lists');
    }

    public function show(string $id)
    {
        $getSubject = Subjects::findOrFail($id);

        $listExams = Exams::all();

        $checkRegister = $this->checkRegisterSubject($id);

        return view('clients.subjects.show', compact('getSubject', 'listExams', 'checkRegister'));
    }

    public function registerSubject(string $id)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;

            $register = User::join('users_subjects', 'users.id', '=', 'users_subjects.user_id')
                ->where('users_subjects.user_id', $user_id)
                ->where('users_subjects.subject_id', $id)
                ->first();

            $register = UsersSubjects::insert([
                'user_id' => $user_id,
                'subject_id' => $id
            ]);

            if ($register) {
                return redirect()->route('subjects.show', ['id' => $id])->with('success', 'Đăng ký thành công');
            } else {
                return redirect()->route('subjects.show', ['id' => $id])->with('error', 'Đăng ký thất bại');
            }
        } else {
            return redirect()->route('subjects.show', ['id' => $id])->with('error', 'Bạn cần đăng nhập để đăng ký');
        }
    }

    public function checkRegisterSubject(string $id)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;

            $check = User::join('users_subjects', 'users.id', '=', 'users_subjects.user_id')
                ->where('users_subjects.user_id', $user_id)
                ->where('users_subjects.subject_id', $id)
                ->first();

            $check = UsersSubjects::where('user_id', $user_id)
                ->where('subject_id', $id)
                ->first();

            return $check;
        } else {
            return false;
        }
    }
}
