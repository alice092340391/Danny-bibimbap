<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '後台管理')</title>
    <link rel="stylesheet" href="{{ asset('css/styles1.css') }}">
    </head>
<body>
    <div class="navbar">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> 儀表板</a>
        <a href="#"><i class="fas fa-utensils"></i> 菜單管理</a>
        </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>