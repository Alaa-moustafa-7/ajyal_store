@extends('layouts.dashboard')

@section('title', 'Create Admin')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Create Admin</li>
@endsection

@section('content')
    <div class="container">

        <form action="{{ route('dashboard.admins.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Name Field --}}
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name') }}" required>
            </div>

            {{-- Email Field --}}
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email') }}" required>
            </div>

            {{-- Password Field --}}
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    required>
            </div>

            {{-- Roles --}}
            <div class="form-group mb-4">
                <label class="form-label d-block">Roles</label>
                @foreach($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            name="roles[]" value="{{ $role->id }}"
                            id="role_{{ $role->id }}">
                        <label class="form-check-label" for="role_{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
