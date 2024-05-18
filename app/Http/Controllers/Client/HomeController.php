<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subjects;

class HomeController extends Controller
{
    public function index()
    {
        $listSubjects = Subjects::all();

        return view('clients.home', compact('listSubjects'));
    }
}
