<x-layout :title="__('admin_register')">
    <div class="container mt-4">
        <h1 class="h4 mb-3">{{ __('admin_register') }}</h1>

        <form method="post" action="{{ route('admin.register.post') }}">
            @csrf

            <div class="form-group mb-2">
                <label for="name" class="mb-1">{{ __('name') }}</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control form-control-sm" 
                    value="{{ old('name') }}" 
                    required>
            </div>

            <div class="form-group mb-2">
                <label for="email" class="mb-1">{{ __('email') }}</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control form-control-sm" 
                    value="{{ old('email') }}" 
                    required>
            </div>

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

            <div class="form-group mb-2">
                <label for="password_confirmation" class="mb-1">{{ __('confirm_password') }}</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <button type="submit" class="btn btn-success btn-sm">{{ __('register') }}</button>
        </form>

        <p class="mt-2 mb-0">
            <a href="{{ route('admin.login') }}">{{ __('back_to_login') }}</a>
        </p>
    </div>
</x-layout>
