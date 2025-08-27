<x-layout :title="__('admin_members')">
    <div class="container mt-4">
        <h1 class="h4 mb-3">{{ __('admin_members') }}</h1>

        <!-- Search Form -->
        <form method="get" class="form-inline mb-3">
            <input 
                type="text" 
                name="s" 
                class="form-control form-control-sm mr-2" 
                value="{{ request('s') }}" 
                placeholder="{{ __('search_placeholder') }}">
            <button type="submit" class="btn btn-primary btn-sm">{{ __('search') }}</button>
        </form>

        <!-- Actions -->
        <p class="mb-3">
            <a href="{{ route('admin.members.create') }}" class="btn btn-success btn-sm">+ {{ __('new') }}</a>
            <a href="{{ route('admin.members.csv', request()->query()) }}" class="btn btn-secondary btn-sm">
                {{ __('export_csv') }}
            </a>
        </p>

        <!-- Members Table -->
        <div class="table-responsive">
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
                    @foreach($admins as $a)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->name }}</td>
                            <td>{{ $a->email }}</td>
                            <td>{{ $a->login_id }}</td>
                            <td>
                                @if($a->email_verified_at)
                                    <span class="badge bg-success">{{ __('verified') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('pending') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.members.edit', $a->id) }}" class="btn btn-sm btn-outline-primary">{{ __('edit') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div>
            {{ $admins->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-layout>
