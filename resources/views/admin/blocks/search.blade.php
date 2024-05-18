@extends('layouts.admin')

@section('title')
    Search
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="row">
        @include('admin.blocks.sidebar')

        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @if (isset($search) && count($listExams) > 0)
                @include('admin.exams.search-exam')
            @elseif (isset($search) && count($listSubjects) > 0)
                @include('admin.subjects.search-subject')
            @else
                <h2 class="pt-3 pb-2 mb-3">Search no results</h2>
            @endif
        </div>
    </div>
@endsection
