<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{{ $title ?? __('app_name') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- ナビゲーションメニュー --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ __('app_name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="{{ __('toggle_navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    {{-- 認証済みメニュー --}}
                    @auth
                        @if(auth()->guard('admin')->check())
                            {{-- 管理者メニュー --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.members.index') }}">{{ __('admin_list') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.customers.index') }}">{{ __('customer_list') }}</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button class="btn btn-link nav-link" type="submit">{{ __('logout') }}</button>
                                </form>
                            </li>
                        @else
                            {{-- 会員メニュー --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('front.mypage.edit') }}">{{ __('mypage') }}</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('front.logout') }}">
                                    @csrf
                                    <button class="btn btn-link nav-link" type="submit">{{ __('logout') }}</button>
                                </form>
                            </li>
                        @endif
                    @else
                        {{-- ゲストメニュー --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.entry') }}">{{ __('register') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.login') }}">{{ __('admin_login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.register') }}">{{ __('member_registration') }}</a>
                        </li>
                    @endauth

                    {{-- 言語切替 --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('language') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.switch', 'ja') }}">{{ __('japanese') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">{{ __('english') }}</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- フラッシュメッセージ --}}
    <div class="container">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- メインコンテンツ --}}
        {{ $slot }}
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
