<x-layout :title="__('admin_login')">
    <div class="container mt-4">
        <h1 class="h4 mb-3">{{ __('admin_login') }}</h1>

        <form method="post" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group mb-2">
                <label for="login_id" class="mb-1">{{ __('login_id') }}</label>
                <input 
                    type="text" 
                    name="login_id" 
                    id="login_id" 
                    class="form-control form-control-sm" 
                    value="{{ old('login_id') }}" 
                    required>
            </div>

            <div class="form-group mb-2">
                <label for="password" class="mb-1">{{ __('password') }}</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <div class="form-check mb-2">
                <input 
                    type="checkbox" 
                    name="remember" 
                    value="1" 
                    class="form-check-input" 
                    id="remember">
                <label class="form-check-label" for="remember">{{ __('remember_me') }}</label>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">{{ __('login') }}</button>
        </form>

        <p class="mt-2 mb-0">
            <a href="{{ route('admin.register') }}">{{ __('create_account') }}</a>
        </p>
    </div>
</x-layout>
