@extends('layouts.dashboard')

@section('title', 'Admins')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.admins.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    </div>

    <x-alert type="success" />
    <x-alert type="info" />


    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td><a href="{{ route('dashboard.admins.show', $admin->id) }}"> {{ $admin->name }}</a></td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->admin }}</td>
                    <td>{{ $admin->created_at }}</td>
                    <td>
                        @can('admins.update')
                            <a href="{{ route('dashboard.admins.edit', $admin->id) }}"
                            class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('admins.delete')
                            <form action="{{ route('dashboard.admins.destroy', $admin->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="delete">
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"> No Admins defined </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $admins->withQueryString()->links() }}

@endsection

{{-- @extends('layouts.dashboard')

@section('title', 'Admins')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.admins.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td><a href="{{ route('dashboard.admins.show', $admin->id) }}">{{ $admin->name }}</a></td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @foreach($admin->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $admin->created_at }}</td>
                    <td>
                        @can('admins.update')
                            <a href="{{ route('dashboard.admins.edit', $admin->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('admins.delete')
                            <form action="{{ route('dashboard.admins.destroy', $admin->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No admins found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $admins->withQueryString()->links() }}

@endsection
 --}}
