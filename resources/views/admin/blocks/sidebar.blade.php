<nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-3 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route('admin.home') }}">
                    <span data-feather="home"></span>
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.subjects') }}">
                    <span data-feather="file"></span>
                    Subjects
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.exams') }}">
                    <span data-feather="file-text"></span>
                    Exams
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.questions') }}">
                    <span data-feather="help-circle"></span>
                    Questions
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.questions') }}">
                    <span data-feather="file-text"></span>
                    Scores
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users') }}">
                    <span data-feather="users"></span>
                    Users
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                </a>
            </li> --}}
        </ul>

        {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Current month
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Last quarter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Social engagement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Year-end sale
                </a>
            </li>
        </ul> --}}
    </div>
</nav>
