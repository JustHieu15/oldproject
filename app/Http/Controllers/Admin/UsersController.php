<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listUsers = User::all();

        return view('admin.users.lists', compact('listUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listUsers = User::all();

        return view('admin.users.create', compact('listUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $insertUser = User::insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if ($insertUser) {
            return redirect()->route('admin.users')->with('success', 'User created successfully');
        } else {
            return redirect()->route('admin.users')->with('error', 'User creation failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getUser = User::findOrFail($id);

        return view('admin.users.show', compact('getUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $request->session()->put('id_user', $id);

        $getUser = User::findOrFail($id);

        $listUsers = User::all();

        return view('admin.users.edit', compact('getUser', 'listUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = session('id_user');

        $data = $request->all();

        $updateUser = User::findOrFail($id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if ($updateUser) {
            return redirect()->route('admin.users')->with('success', 'User updated successfully');
        } else {
            return redirect()->route('admin.users')->with('error', 'User update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (User::findOrFail($id)->delete()) {
            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('admin.users')->with('error', 'User deletion failed');
        }
    }
}
