@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User List</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            + Add User
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="50">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="{{ route('users.delete',$user->id) }}"
                           onclick="return confirm('Are you sure?')"
                           class="btn btn-danger btn-sm">
                            Delete
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No users found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
