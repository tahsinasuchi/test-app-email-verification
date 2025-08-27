<x-layout :title="__('mypage')">
    <div class="container mt-5">
        <h1 class="mb-4">{{ __('mypage_edit') }}</h1>

        <form method="post" action="{{ route('front.mypage.update') }}">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('name') }}</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    value="{{ old('name', $customer->name) }}" 
                    required>
            </div>

            <div class="form-group">
                <label for="email">{{ __('email') }}</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    value="{{ old('email', $customer->email) }}" 
                    required>
            </div>

            <div class="form-group">
                <label for="login_id">{{ __('login_id') }}</label>
                <input 
                    type="text" 
                    name="login_id" 
                    id="login_id" 
                    class="form-control" 
                    value="{{ old('login_id', $customer->login_id) }}" 
                    required>
            </div>

            <div class="form-group">
                <label for="password">{{ __('new_password') }}</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('confirm_password') }}</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
        </form>

        <form method="post" action="{{ route('front.logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">{{ __('logout') }}</button>
        </form>
    </div>
</x-layout>
