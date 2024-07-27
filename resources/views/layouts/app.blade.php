<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">Laravel App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @if (Auth::user()->role->name == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">Admin</a>
                        </li>
                    @elseif (Auth::user()->role->name == 'doctor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctor') }}">Doctor</a>
                        </li>
                    @elseif (Auth::user()->role->name == 'patient')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient') }}">Patient</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li> -->
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @auth
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        @if (Auth::user()->role->name == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                                    <i class="fas fa-cog"></i> Admin Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.invoices.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin/invoices*') ? 'active' : '' }}">Invoices</a>
                            </li>
                        @elseif (Auth::user()->role->name == 'doctor')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('doctor') ? 'active' : '' }}" href="{{ route('doctor') }}">
                                    <i class="fas fa-stethoscope"></i> Doctor Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                    <i class="fas fa-file-invoice"></i> Invoices
                                </a>
                            </li>
                        @elseif (Auth::user()->role->name == 'patient')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('patient') ? 'active' : '' }}" href="{{ route('patient') }}">
                                    <i class="fas fa-user"></i> Patient Dashboard
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            @endauth

            <!-- Content Area -->
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">© {{ date('Y') }} Laravel App</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
