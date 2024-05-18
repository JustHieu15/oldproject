@extends('layouts.admin')

@section('title')
    Home
@endsection

@section('content')
    <div class="row">
        @include('admin.blocks.sidebar')
        @include('admin.blocks.content')
    </div>
@endsection
