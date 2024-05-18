@extends('layouts.admin')

@section('title')
    Create User
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="row">
        @include('admin.blocks.sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="pt-3 pb-2 mb-3">Create User</h2>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name_user" class="form-control" placeholder="Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Gender</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Female
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                            <label class="form-check-label" for="flexRadioDefault3">
                                Other
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="">Date of Birth</label>
                        <input type="date" name="dob_user" class="form-control" placeholder="Date of Birth" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="email" name="email_user" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password_user" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Confirm Password</label>
                        <input type="confirm Password" name="confirm Password_user" class="form-control"
                            placeholder="Confirm Password" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
