<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            @yield('info-page')
        </nav>
        <a class="btn btn-primary d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="fa-solid fa-bars"></i>
        </a>
    </div>
    <div class="offcanvas offcanvas-start w-100" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">

        <div class="offcanvas-header">
            <a class="align-items-center d-flex  navbar-brand text-wrap" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/img/logofakultas.png') }}" class="w-75" alt="...">
            </a>
            <button type="button" class=" btn btn-transparent" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
          </div>
        <div class="offcanvas-body">
            <ul class="text-decoration-none list-unstyled">
                <li class="nav-item">
                    <a class=" d-flex  nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/quiz.png') }}" width="11px" height="11px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop</title>
                        </div>
                        <p class="m-1 ">Quiz</p>
                    </a>
                </li>
                <li class="nav-item my-3">
                    <h3 class=" ms-2 text-uppercase font-weight-bolder opacity-6">
                        Feature
                    </h3>
                </li>
                <li class="nav-item">
                    <a class="d-flex  nav-link {{ Request::is('user/profile') ? 'active' : '' }}"
                        href="{{ url('user/profile') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/avatar.png') }}" width="14px" height="14px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 ">User Profile</p>
                    </a>
                </li>
                @isRole(['admin', 'lecturer'])
                    <li class="nav-item">
                        <a class="d-flex  nav-link {{ Request::is('user') ? 'active' : '' }} {{ Request::is('user/create-csv') ? 'active' : '' }}"
                            href="{{ url('user') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/img/group.png') }}" width="14px" height="14px"
                                    viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>shop </title>
                            </div>
                            <p class="m-1 ">User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex  nav-link {{ Request::is('question') ? 'active' : '' }}  " href="{{ url('question') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/img/question.png') }}" width="14px" height="14px"
                                    viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>shop </title>
                            </div>
                            <p class="m-1 ">Generate Question</p>
                        </a>
                    </li>
                @endisRole

                <li class="nav-item">
                    <a class="d-flex  nav-link {{ Request::is('course') ? 'active' : '' }} {{ Request::is('topic/*') ? 'active open' : '' }} {{ Request::is('question/*') ? 'active open' : '' }} {{ Request::is('grade/*') ? 'active open' : '' }} {{ Request::is('user/answer/*') ? 'active open' : '' }} {{ Request::is('answer/detail/*') ? 'active open' : '' }} {{ Request::is('student/*') ? 'active open' : '' }} {{ Request::is('assistant/*') ? 'active open' : '' }}"
                        href="{{ url('course') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/learning.png') }}" width="14px" height="14px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 ">Course</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="d-flex  nav-link " role="button" id="logout">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-logout.png') }}" width="12px" height="12px"
                                viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">

                            <title>spaceship</title>
                        </div>
                        <p class="m-1 ">Logout</p>
                    </a>
                </li>
            </ul>
        </div>
      </div>
</nav>
