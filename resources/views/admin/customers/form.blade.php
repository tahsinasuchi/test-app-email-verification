<x-layout :title="__('member_form')">
    <div class="container mt-4">
        <h1 class="h4 mb-3">
            {{ $customer->id ? __('customer_edit') : __('member_new') }}
        </h1>

        <form method="post" action="{{ $customer->id ? route('admin.customers.update',$customer->id) : route('admin.customers.store') }}">
            @csrf
            @if($customer->id)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name" class="required">{{ __('name') }}</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $customer->name) }}" 
                    class="form-control form-control-sm " 
                    required>
            </div>

            <div class="form-group">
                <label for="email"  class="required">{{ __('email') }}</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $customer->email) }}" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <div class="form-group">
                <label for="login_id"  class="required">{{ __('login_id') }}</label>
                <input 
                    type="text" 
                    id="login_id" 
                    name="login_id" 
                    value="{{ old('login_id', $customer->login_id) }}" 
                    class="form-control form-control-sm" 
                    required>
            </div>

            <div class="form-group">
                <label for="password"  class={{ $customer->id ? '' : 'required' }}>
                    {{ $customer->id ? __('password_leave_blank') : __('password') }}
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control form-control-sm"
                    {{ $customer->id ? '' : 'required' }}>
            </div>

            <div class="form-group mb-2">
                <label for="password_confirmation"  class={{ $customer->id ? '' : 'required' }}>{{ __('password_confirm') }}</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control form-control-sm"
                    {{ $customer->id ? '' : 'required' }}>
            </div>

            <button type="submit" class="btn btn-primary btn-sm  mb-2">
                {{ $customer->id ? __('update') : __('create') }}
            </button>
            
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm  mb-2">
                {{ __('back_to_list') }}
            </a>
        </form>
        @if($customer->id)
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" 
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
