<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>農作業日誌アプリ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('head')
</head>

<body class="{{ str_replace('.', '-', Route::currentRouteName()) }}">
    <header class="main-header">
        <div class="header-container">
            <h1><a href="{{ route('works.index') }}">農作業日誌</a></h1>

            <form method="GET" action="{{ route('works.index') }}" class="search-form">
                <input type="text" name="keyword" placeholder="キーワード" value="{{ request('keyword') }}">
                <input type="date" name="start_date" value="{{ request('start_date') }}">
                <input type="date" name="end_date" value="{{ request('end_date') }}">
                <button type="submit">検索</button>
            </form>

            <nav>
                @auth
                <span>{{ Auth::user()->name }}さん</span> /
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
                @else
                <a href="{{ route('login') }}">ログイン</a>
                <a href="{{ route('register') }}">会員登録</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="main-container">
        @yield('content')
    </main>

    <footer>
        <small>&copy; {{ date('Y') }} 農作業日誌アプリ</small>
        @yield('scripts')
    </footer>
</body>

</html>