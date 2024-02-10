<aside
    class="sidenav navbar navbar-vertical bg-dark navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-3 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logofakultas.png') }}" class="navbar-brand-img" alt="...">
        </a>
    </div>

    <hr class="horizontal light mt-0">
    <div class="menu">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-dashboard.png') }}" width="11px" height="11px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop</title>
                        </div>
                        <p class="m-1 textSidebar">Dashboard</p>
                    </a>
                </li>
                <li class="TextSidebar mt-2">
                    <h6 class="textSidebar ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Master
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('question') ? 'active' : '' }}" href="{{ url('question') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-inventory.png') }}" width="14px" height="14px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 textSidebar">Question</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('karyawan') ? 'active' : '' }}" href="{{ url('karyawan') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-datakaryawan.png') }}" width="13px" height="13px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 textSidebar">Employee</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kategori') ? 'active' : '' }}" href="{{ url('kategori') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-category.png') }}" width="14px" height="14px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 textSidebar">Category</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('ruangan') ? 'active' : '' }}" href="{{ url('ruangan') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-rooms.png') }}" width="14px" height="14px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 textSidebar">Room</p>
                    </a>
                </li>

                <li class="TextSidebar mt-2">
                    <h6 class="textSidebar ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Report
                        History</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('perbaikan') ? 'active' : '' }}" href="{{ url('perbaikan') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-repair.png') }}" width="12px" height="12px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 textSidebar">Repair History</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('historyPemakaian') ? 'active' : '' }}"
                        href="{{ url('historyPemakaian') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-usage.png') }}" width="13px" height="13px"
                                viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                        </div>
                        <p class="m-1 textSidebar">Usage History</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link " role="button" id="logout">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/icon-logout.png') }}" width="12px" height="12px"
                                viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">

                            <title>spaceship</title>
                        </div>
                        <p class="m-1 textSidebar">Logout</p>
                    </a>
                </li>
            </ul>
        </div>
        </ul>
    </div>


</aside>
