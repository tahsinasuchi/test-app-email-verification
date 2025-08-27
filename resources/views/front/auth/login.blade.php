<x-layout :title="__('login')">
    <div class="container mt-5">
        <h1 class="mb-4">{{ __('login') }}</h1>

        <form method="post" action="{{ route('front.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="login_id">{{ __('login_id') }}</label>
                <input 
                    type="text" 
                    name="login_id" 
                    id="login_id" 
                    class="form-control" 
                    value="{{ old('login_id') }}" 
                    required>
            </div>

            <div class="form-group">
                <label for="password">{{ __('password') }}</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control" 
                    required>
            </div>

            <div class="form-group form-check">
                <input 
                    type="checkbox" 
                    name="remember" 
                    value="1" 
                    class="form-check-input" 
                    id="remember">
                <label class="form-check-label" for="remember">{{ __('remember_me') }}</label>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('login') }}</button>
        </form>

        <p class="mt-3">
            <a href="{{ route('front.entry') }}">{{ __('create_account') }}</a>
        </p>
    </div>
</x-layout>
