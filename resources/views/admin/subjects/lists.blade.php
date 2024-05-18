@extends('layouts.admin')

@section('title')
    Subjects
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="row">
        @include('admin.blocks.sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="pt-3 pb-2 mb-3">Subjects</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject Name</th>
                            <th>Subject Detail</th>
                            <th>Subject Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listSubjects as $key => $subject)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->description }}</td>
                                <td width="12%">
                                    <img src="{{ asset('storage/' . $subject->image) }}" alt="" class="img-fluid">
                                </td>
                                <td>
                                    <a href="{{ route('admin.subjects.show', $subject->id) }}"
                                        class="btn btn-sm btn-success">Manage Exams</a>

                                    <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>

                                    <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">Add Subject</a>
        </div>
    </div>
@endsection
