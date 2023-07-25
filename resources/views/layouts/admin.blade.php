<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, viewport-fit=cover"
        />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>
            @yield('title')
        </title>


        <!-- CSS files -->
        <link href="/tabler/demo/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
        <link
            href="/tabler/demo/dist/css/tabler-flags.min.css?1684106062"
            rel="stylesheet"
        />
        <link
            href="/tabler/demo/dist/css/tabler-payments.min.css?1684106062"
            rel="stylesheet"
        />
        <link
            href="/tabler/demo/dist/css/tabler-vendors.min.css?1684106062"
            rel="stylesheet"
        />
        <link href="/tabler/demo/dist/css/demo.min.css?1684106062" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @stack('addStyle')
        <style>
            @import url("https://rsms.me/inter/inter.css");
            :root {
                --tblr-font-sans-serif: "Inter Var", -apple-system,
                    BlinkMacSystemFont, San Francisco, Segoe UI, Roboto,
                    Helvetica Neue, sans-serif;
            }
            body {
                font-feature-settings: "cv03", "cv04", "cv11";
            }
            body{
                background-color: #f6f8fb !important;
            }


        </style>
    </head>
    <body class="layout-fluid">
        <script src="/tabler/demo/dist/js/demo-theme.min.js?1684106062"></script>
        <div class="page">
            <!-- Sidebar -->
            <aside class="navbar navbar-vertical navbar-expand-lg"
                data-bs-theme="dark">
                <div class="container-fluid">
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#sidebar-menu"
                        aria-controls="sidebar-menu"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1 class="navbar-brand navbar-brand-autodark">
                        <a href=".">

                        </a>
                    </h1>
                    <div class="navbar-nav flex-row d-lg-none">
                        <div class="nav-item d-none d-lg-flex me-3">
                            <div class="btn-list">
                                <a
                                    href="https://github.com/tabler/demo/tabler"
                                    class="btn"
                                    target="_blank"
                                    rel="noreferrer"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        />
                                        <path
                                            d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"
                                        />
                                    </svg>
                                    Source code
                                </a>
                                <a
                                    href="https://github.com/sponsors/codecalm"
                                    class="btn"
                                    target="_blank"
                                    rel="noreferrer"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon text-pink"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        />
                                        <path
                                            d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"
                                        />
                                    </svg>
                                    Sponsor
                                </a>
                            </div>
                        </div>
                        <div class="d-none d-lg-flex">
                            <a
                                href="?theme=dark"
                                class="nav-link px-0 hide-theme-dark"
                                title="Enable dark mode"
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                            >
                                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <path
                                        d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"
                                    />
                                </svg>
                            </a>
                            <a
                                href="?theme=light"
                                class="nav-link px-0 hide-theme-light"
                                title="Enable light mode"
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                            >
                                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <path
                                        d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"
                                    />
                                    <path
                                        d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"
                                    />
                                </svg>
                            </a>
                            <div
                                class="nav-item dropdown d-none d-md-flex me-3"
                            >
                                <a
                                    href="#"
                                    class="nav-link px-0"
                                    data-bs-toggle="dropdown"
                                    tabindex="-1"
                                    aria-label="Show notifications"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        />
                                        <path
                                            d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"
                                        />
                                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                    </svg>
                                    <span class="badge bg-red"></span>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card"
                                >
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Last updates
                                            </h3>
                                        </div>
                                        <div
                                            class="list-group list-group-flush list-group-hoverable"
                                        >
                                            <div class="list-group-item">
                                                <div
                                                    class="row align-items-center"
                                                >
                                                    <div class="col-auto">
                                                        <span
                                                            class="status-dot status-dot-animated bg-red d-block"
                                                        ></span>
                                                    </div>
                                                    <div
                                                        class="col text-truncate"
                                                    >
                                                        <a
                                                            href="#"
                                                            class="text-body d-block"
                                                            >Example 1</a
                                                        >
                                                        <div
                                                            class="d-block text-muted text-truncate mt-n1"
                                                        >
                                                            Change deprecated
                                                            html tags to text
                                                            decoration classes
                                                            (#29604)
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a
                                                            href="#"
                                                            class="list-group-item-actions"
                                                        >
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon text-muted"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="2"
                                                                stroke="currentColor"
                                                                fill="none"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            >
                                                                <path
                                                                    stroke="none"
                                                                    d="M0 0h24v24H0z"
                                                                    fill="none"
                                                                />
                                                                <path
                                                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                                />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item">
                                                <div
                                                    class="row align-items-center"
                                                >
                                                    <div class="col-auto">
                                                        <span
                                                            class="status-dot d-block"
                                                        ></span>
                                                    </div>
                                                    <div
                                                        class="col text-truncate"
                                                    >
                                                        <a
                                                            href="#"
                                                            class="text-body d-block"
                                                            >Example 2</a
                                                        >
                                                        <div
                                                            class="d-block text-muted text-truncate mt-n1"
                                                        >
                                                            justify-content:between
                                                            ⇒
                                                            justify-content:space-between
                                                            (#29734)
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a
                                                            href="#"
                                                            class="list-group-item-actions show"
                                                        >
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon text-yellow"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="2"
                                                                stroke="currentColor"
                                                                fill="none"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            >
                                                                <path
                                                                    stroke="none"
                                                                    d="M0 0h24v24H0z"
                                                                    fill="none"
                                                                />
                                                                <path
                                                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                                />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item">
                                                <div
                                                    class="row align-items-center"
                                                >
                                                    <div class="col-auto">
                                                        <span
                                                            class="status-dot d-block"
                                                        ></span>
                                                    </div>
                                                    <div
                                                        class="col text-truncate"
                                                    >
                                                        <a
                                                            href="#"
                                                            class="text-body d-block"
                                                            >Example 3</a
                                                        >
                                                        <div
                                                            class="d-block text-muted text-truncate mt-n1"
                                                        >
                                                            Update
                                                            change-version.js
                                                            (#29736)
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a
                                                            href="#"
                                                            class="list-group-item-actions"
                                                        >
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon text-muted"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="2"
                                                                stroke="currentColor"
                                                                fill="none"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            >
                                                                <path
                                                                    stroke="none"
                                                                    d="M0 0h24v24H0z"
                                                                    fill="none"
                                                                />
                                                                <path
                                                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                                />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item">
                                                <div
                                                    class="row align-items-center"
                                                >
                                                    <div class="col-auto">
                                                        <span
                                                            class="status-dot status-dot-animated bg-green d-block"
                                                        ></span>
                                                    </div>
                                                    <div
                                                        class="col text-truncate"
                                                    >
                                                        <a
                                                            href="#"
                                                            class="text-body d-block"
                                                            >Example 4</a
                                                        >
                                                        <div
                                                            class="d-block text-muted text-truncate mt-n1"
                                                        >
                                                            Regenerate
                                                            package-lock.json
                                                            (#29730)
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a
                                                            href="#"
                                                            class="list-group-item-actions"
                                                        >
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon text-muted"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="2"
                                                                stroke="currentColor"
                                                                fill="none"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            >
                                                                <path
                                                                    stroke="none"
                                                                    d="M0 0h24v24H0z"
                                                                    fill="none"
                                                                />
                                                                <path
                                                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                                />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a
                                href="#"
                                class="nav-link d-flex lh-1 text-reset p-0"
                                data-bs-toggle="dropdown"
                                aria-label="Open user menu"
                            >
                                <span
                                    class="avatar avatar-sm"
                                    style="
                                        background-image: url(./static/avatars/000m.jpg);
                                    "
                                ></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Paweł Kuna</div>
                                    <div class="mt-1 small text-muted">
                                        UI Designer
                                    </div>
                                </div>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                            >
                                <a href="#" class="dropdown-item">Status</a>
                                <a href="./profile.html" class="dropdown-item"
                                    >Profile</a
                                >
                                <a href="#" class="dropdown-item">Feedback</a>
                                <div class="dropdown-divider"></div>
                                <a href="./settings.html" class="dropdown-item"
                                    >Settings</a
                                >
                                <a href="./sign-in.html" class="dropdown-item"
                                    >Logout</a
                                >
                            </div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="sidebar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item {{request()->is('admin') ? 'active' : ''}}">
                                <a class="nav-link" href="/admin">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"
                                        ><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            />
                                            <path
                                                d="M5 12l-2 0l9 -9l9 9l-2 0"
                                            />
                                            <path
                                                d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"
                                            />
                                            <path
                                                d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"
                                            />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Home </span>
                                </a>
                            </li>


                            {{-- <li class="nav-item {{request()->is('admin/calon*') ? 'active' : ''}}">
                                <a class="nav-link" href="{{route('admin.calon-legislatif.index')}}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"
                                        >
                                        <i class="bi bi-people"></i>
                                    </span>
                                    <span class="nav-link-title"> Calon Legislatif </span>
                                </a>
                            </li> --}}
                            <li class="nav-item {{request()->is('admin/lokasi*') ? 'active' : ''}}">
                                <a class="nav-link" href="{{route('admin.lokasi.index')}}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"
                                        >
                                        <i class="bi bi-globe-americas"></i>
                                    </span>
                                    <span class="nav-link-title"> Lokasi Survey </span>
                                </a>
                            </li>


                            <li class="nav-item dropdown {{request()->is("admin/data*") ? "active" : ''}}">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#navbar-extra"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="false"
                                    role="button"
                                    aria-expanded="false"
                                >
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"
                                        ><!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                        <i class="bi bi-database-fill-check"></i>
                                    </span>
                                    <span class="nav-link-title"> Data </span>
                                </a>
                                <div class="dropdown-menu {{request()->is("admin/data*") ? "show" : ''}}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a
                                                class="dropdown-item {{request()->is("admin/data/relawan*") ? "active" : ''}}"
                                                href="{{ route('admin.data.relawan.index') }}"
                                            >
                                                Relawan
                                            </a>
                                            <a
                                                class="dropdown-item {{request()->is("admin/data/user*") ? "active" : ''}}"
                                                href="{{ route('admin.data.user.index') }}"
                                            >
                                                Surveyor
                                            </a>
                                            <a
                                                class="dropdown-item {{request()->is("admin/data/responden*") ? "active" : ''}}"
                                                href="{{ route('admin.data.responden.index') }}"
                                            >
                                                Responden
                                            </a>
                                            <a
                                                class="dropdown-item {{request()->is("admin/data/bank-soal*") ? "active" : ''}}"
                                                href="{{route('admin.data.bank-soal.index')}}"
                                            >
                                                Kuisioner
                                            </a>
                                            <a
                                                class="dropdown-item {{request()->is("admin/data/kuisioner-kecamatan*") ? "active" : ''}}"
                                                href="{{route('admin.data.kuisioner-kecamatan.index')}}"
                                            >
                                                Kuisioner Kecamatan
                                            </a>
                                            {{-- <a
                                                class="dropdown-item {{request()->is("admin/data/report*") ? "active" : ''}}"
                                                href="{{ route('admin.data.report') }}"
                                            >
                                                Report Grafik
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item {{request()->is('admin/quick-qount*') ? 'active' : ''}}">
                                <a class="nav-link" href="{{route('admin.quick-qount')}}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"
                                        >
                                        <i class="bi bi-box2"></i>
                                    </span>
                                    <span class="nav-link-title"> Realcount </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </aside>
            <div class="page-wrapper">
                <!-- Page header -->
                <div class="page-header d-print-none">
                    <div class="container-xl">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <!-- Page pre-title -->
                                <div class="page-pretitle">page</div>
                                <h2 class="page-title">
                                    @yield('title', 'Admin')
                                </h2>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Page body -->
                <div class="page-body">
                    <div class="container-xl">
                        @if ($errors->any())
                            <div class="mb-3">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (Session::get('alert_success'))
                            <div class="mb-3">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                        <!-- SVG icon from http://tabler-icons.io/i/check -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                        </div>
                                        <div>
                                        <h4 class="alert-title">Success!</h4>
                                        <div class="text-muted">{{Session::get('alert_success')}}</div>
                                        </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
                <footer class="footer footer-transparent d-print-none">
                    <div class="container"></div>
                </footer>
            </div>
        </div>

        <!-- Libs JS -->
        <script
            src="/tabler/demo/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062"
            defer
        ></script>
        <script
            src="/tabler/demo/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062"
            defer
        ></script>
        <script
            src="/tabler/demo/dist/libs/jsvectormap/dist/maps/world.js?1684106062"
            defer
        ></script>
        <script
            src="/tabler/demo/dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062"
            defer
        ></script>
        <!-- Tabler Core -->
        <script src="{{asset('tabler/demo/dist/libs/tom-select/dist/js/tom-select.base.js')}}" defer></script>
        <script src="/tabler/demo/dist/js/tabler.min.js?1684106062" defer></script>
        <script src="/tabler/demo/dist/js/demo.min.js?1684106062" defer></script>

        {{--  --}}
        <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="{{asset("tabler/demo/dist/libs/fslightbox/index.js")}}"></script>



        @if (Session::has('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ Session::get('success') }}',
                    icon: 'success',
                })
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                Swal.fire({
                    title: 'Failed!',
                    text: '{{ Session::get('error') }}',
                    icon: 'error',
                })


            </script>
        @endif

        <script>
            $('.delete_confirm').click(function(event) {
                var form =  $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>

        @stack('addScript')
    </body>
</html>
