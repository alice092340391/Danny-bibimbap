<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '後台管理') - Danny Bibimbap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { display: flex; }
        .sidebar { width: 250px; height: 100vh; position: fixed; top: 0; left: 0; background-color: #343a40; padding-top: 20px; }
        .sidebar a { padding: 15px 20px; text-decoration: none; font-size: 18px; color: #adb5bd; display: block; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background-color: #495057; }
        .sidebar .logout-form { padding: 15px 20px; }
        .main-content { margin-left: 250px; padding: 20px; width: calc(100% - 250px); }
        .border-left-primary { border-left: .25rem solid #4e73df!important; }
        .border-left-success { border-left: .25rem solid #1cc88a!important; }
        .border-left-warning { border-left: .25rem solid #f6c23e!important; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5 class="text-white text-center mb-4">Danny Bibimbap</h5>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-tachometer-alt fa-fw me-2"></i>儀表板
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt fa-fw me-2"></i>訂單管理
        </a>
        <a href="{{ route('admin.menus.index') }}" class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
            <i class="fa-solid fa-utensils fa-fw me-2"></i>菜單管理
        </a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-dark w-100 text-start">
                <i class="fa-solid fa-right-from-bracket fa-fw me-2"></i>登出
            </button>
        </form>
    </div>
    <div class="main-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
