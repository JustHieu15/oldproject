@extends('layouts.admin')

@section('title')
    Questions
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="row">
        @include('admin.blocks.sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="pt-3 pb-2 mb-3">Questions</h2>

            @php $i = 1; @endphp
            {{-- Search --}}
            <form action="{{ route('admin.questions') }}" method="GET">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-select" name="exam" id="exam">
                                <option value="" selected>All Exam</option>
                                @foreach ($listExams as $exam)
                                    <option value="{{ $exam->id }}"
                                        {{ request()->exam == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>


            {{-- Table --}}
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($search))
                            @foreach ($listQuestions as $question)
                                @if ($question->exam_id == $search)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $question->name }}</td>
                                        <td>
                                            @foreach ($listSubjects as $subject)
                                                @foreach ($listExams as $exam)
                                                    @if ($exam->id == $question->exam_id && $exam->subject_id == $subject->id)
                                                        {{ $subject->name }}
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($listExams as $exam)
                                                @if ($exam->id == $question->exam_id)
                                                    {{ $exam->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $question->option_a }}</td>
                                        <td>{{ $question->option_b }}</td>
                                        <td>{{ $question->option_c }}</td>
                                        <td>{{ $question->option_d }}</td>
                                        <td>{{ $question->correct_answer }}</td>
                                        <td>
                                            <a href="{{ route('admin.questions.edit', $question->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <form action="{{ route('admin.questions.destroy', $question->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            @foreach ($listQuestions as $key => $question)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $question->name }}</td>
                                    <td>
                                        @foreach ($listSubjects as $subject)
                                            @foreach ($listExams as $exam)
                                                @if ($exam->id == $question->exam_id && $exam->subject_id == $subject->id)
                                                    {{ $subject->name }}
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($listExams as $exam)
                                            @if ($exam->id == $question->exam_id)
                                                {{ $exam->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $question->option_a }}</td>
                                    <td>{{ $question->option_b }}</td>
                                    <td>{{ $question->option_c }}</td>
                                    <td>{{ $question->option_d }}</td>
                                    <td>{{ $question->correct_answer }}</td>
                                    <td>
                                        <a href="{{ route('admin.questions.edit', $question->id) }}"
                                            class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">Add Question</a>
        </div>
    </div>
@endsection
