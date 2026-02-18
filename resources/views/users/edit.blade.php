@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Edit User</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('users.update',$user->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name',$user->name) }}"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email',$user->email) }}"
                               class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button class="btn btn-primary">
                            Update User
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

@endsection
