<x-layout :title="__('entry')">
    <div class="container mt-5">
        <h1 class="mb-4">{{ __('registration') }}</h1>

        <form method="post" action="{{ route('front.entry.post') }}">
            @csrf

            <div class="form-group">
                <label for="name">{{ __('name') }}</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    value="{{ old('name') }}" 
                    required>
            </div>

            <div class="form-group">
                <label for="email">{{ __('email') }}</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    value="{{ old('email') }}" 
                    required>
            </div>

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

            <div class="form-group">
                <label for="password_confirmation">{{ __('confirm_password') }}</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-control" 
                    required>
            </div>

            <button type="submit" class="btn btn-success">{{ __('register') }}</button>
        </form>

        <p class="mt-3">
            <a href="{{ route('login') }}">{{ __('back_to_login') }}</a>
        </p>
    </div>
</x-layout>
