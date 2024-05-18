@extends('layouts.admin')

@section('title')
    Manage Questions Exam
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="row">
        @include('admin.blocks.sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @php $i = 1; @endphp

            <h2 class="pt-3 pb-2 mb-3">Manage Questions Exam: {{ $getExam->name }}</h2>

            <h5 class="pt-3 pb-2 mb-3">Total questions:
                {{ $maxQuestions }}/{{ $getExam->number_of_questions }}</h5>


            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Subject</th>
                            <th>Exam</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                            <th>Correct Answer</th>
                            <th>Question Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listQuestions as $question)
                            @if ($getExam->id == $question->exam_id)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $question->name }}</td>
                                    <td>
                                        @foreach ($listSubjects as $subject)
                                            @if ($getExam->id == $question->exam_id && $getExam->subject_id == $subject->id)
                                                {{ $subject->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($getExam->id == $question->exam_id)
                                            {{ $getExam->name }}
                                        @endif
                                    </td>
                                    <td>{{ $question->option_a }}</td>
                                    <td>{{ $question->option_b }}</td>
                                    <td>{{ $question->option_c }}</td>
                                    <td>{{ $question->option_d }}</td>
                                    <td>{{ $question->correct_answer }}</td>
                                    <td>
                                        <a href="{{ route('admin.questions.editByExam', $question->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.questions.destroyByExam', $question->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                @if ($maxQuestions == $getExam->number_of_questions)
                    <div class="alert alert-success">You have reached the maximum number of questions for this
                        exam.
                    </div>
                @else
                    <a href="{{ route('admin.questions.createByExam', $getExam->id) }}" class="btn btn-primary">Add
                        Question</a>
                @endif
            </div>
        </div>
    @endsection
