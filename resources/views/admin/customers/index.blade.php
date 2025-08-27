<x-layout :title="__('customer_list')">
    <div class="container mt-4">
        <h1 class="h4 mb-3">{{ __('customer_list') }}</h1>

        <form method="get" class="form-inline mb-3">
            <input 
                type="text" 
                name="s" 
                value="{{ request('s') }}" 
                placeholder="{{ __('search_placeholder') }}" 
                class="form-control form-control-sm mr-2">
            <button class="btn btn-primary btn-sm">{{ __('search') }}</button>
        </form>

        <p>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-success btn-sm">{{ __('new') }}</a>
            <a href="{{ route('admin.customers.csv') }}" class="btn btn-secondary btn-sm">{{ __('export_csv') }}</a>
        </p>

        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('id') }}</th>
                    <th>{{ __('name') }}</th>
                    <th>{{ __('email') }}</th>
                    <th>{{ __('login_id') }}</th>
                    <th>{{ __('verified') }}</th>
                    <th>{{ __('actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->login_id }}</td>
                        <td>
                            <span class="badge {{ $c->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                {{ $c->email_verified_at ? __('verified_status') : __('pending_status') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.customers.edit', $c->id) }}" class="btn btn-sm btn-outline-primary">
                                {{ __('edit') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">{{ __('no_members') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div>
            {{ $customers->links() }}
        </div>
    </div>
</x-layout>
