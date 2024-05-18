@extends('layouts.admin')

@section('title')
    Edit Exam
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="row">
        @include('admin.blocks.sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="pt-3 pb-2 mb-3">Edit Exam: {{ $getExam->name }}</h2>
            <form action="{{ route('admin.exams.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Exam Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Exam Name"
                        value="{{ $getExam->name }}">
                </div>

                <div class="mb-3">
                    <label for="timeLimit" class="form-label">Time Limit</label>
                    <select class="form-select" name="timeLimit">
                        <option value="10">10 minute</option>
                        <option value="20">20 minute</option>
                        <option value="30">30 minute</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="limitQuest" class="form-label">Limit Question</label>
                    <input type="number" class="form-control" id="limitQuest" name="limitQuest"
                        placeholder="Limit Question" value="{{ $getExam->number_of_questions }}">
                </div>

                <div class="mb-3">
                    <label for="desc" class="form-label">Description</label>
                    <textarea class="form-control" id="desc" rows="5" name="desc">{{ $getExam->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="hidden" class="form-control" id="subject" name="subject" value="{{ $getSubject->id }}">

                    <input type="text" class="form-control" id="subject" name="subject" value="{{ $getSubject->name }}"
                        disabled>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
