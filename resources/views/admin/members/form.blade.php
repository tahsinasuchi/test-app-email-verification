<x-layout :title="__('admin_form')">
    <div class="container mt-4">
        <h1 class="h4 mb-3">
            {{ $admin->id ? __('admin_edit') : __('admin_new') }}
        </h1>

        <form method="post" action="{{ $admin->id ? route('admin.members.update',$admin->id) : route('admin.members.store') }}">
            @csrf
            @if($admin->id)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name"  class="required">{{ __('name') }}</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $admin->name) }}" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <div class="form-group">
                <label for="email"  class="required">{{ __('email') }}</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $admin->email) }}" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <div class="form-group">
                <label for="login_id"  class="required">{{ __('login_id') }}</label>
                <input 
                    type="text" 
                    id="login_id" 
                    name="login_id" 
                    value="{{ old('login_id', $admin->login_id) }}" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <div class="form-group">
                <label for="password"  class={{ $admin->id ? '' : 'required' }}>
                    {{ __('password') }}
                    @if($admin->id)
                        {{ __('password_leave_blank') }}
                    @endif
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control form-control-sm"
                    {{ $admin->id ? '' : 'required' }}>
            </div>

            <div class="form-group  mb-2">
                <label for="password_confirmation"  class={{ $admin->id ? '' : 'required' }}>{{ __('confirm_password') }}</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control form-control-sm"
                    {{ $admin->id ? '' : 'required' }}>
            </div>

            <button type="submit" class="btn btn-primary btn-sm  mb-2">
                {{ $admin->id ? __('update') : __('create') }}
            </button>
            
            
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm mb-2">
                {{ __('back_to_list') }}
            </a>
        </form>
        @if($admin->id)
                <form action="{{ route('admin.members.destroy', $admin->id) }}" 
                        method="POST" 
                        class="d-inline"
                        onsubmit="return confirm('{{ __('Are you sure you want to delete this customer?') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm  mb-2">
                        {{ __('Delete') }}
                    </button>
                </form>
            @endif
    </div>
</x-layout>
