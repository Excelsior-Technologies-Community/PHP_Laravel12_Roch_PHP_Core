@extends('layouts.app')

@section('content')

<div class="dark-page d-flex align-items-center justify-content-center py-4">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg rounded-4 dark-card">

                    <div class="card-header border-0 text-center bg-transparent pt-4 pb-2">

                        <h3 class="fw-bold text-light mb-1">
                            {{ __('messages.update_user') }}
                        </h3>

                        <small class="text-secondary">
                            Update user details
                        </small>

                    </div>

                    <div class="card-body px-4 py-3">

                        <form method="POST" action="{{ route('users.update',$user->id) }}" id="editUserForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label text-light">{{ __('messages.name') }}</label>
                                <input type="text"
                                    name="name"
                                    value="{{ old('name',$user->name) }}"
                                    class="form-control dark-input"
                                    placeholder="Enter name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-light">{{ __('messages.email') }}</label>
                                <input type="email"
                                    name="email"
                                    value="{{ old('email',$user->email) }}"
                                    class="form-control dark-input"
                                    placeholder="Enter email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-light">{{ __('messages.status') }}</label>
                                <select name="status" class="form-select dark-input">
                                    <option value="active"
                                        {{ $user->status == 'active' ? 'selected' : '' }}>
                                        {{ __('messages.active') }}
                                    </option>
                                    <option value="inactive"
                                        {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                        {{ __('messages.inactive') }}
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between mt-3">

                                <a href="{{ route('users.index') }}"
                                    class="btn btn-outline-light px-4 rounded-3">
                                    {{ __('messages.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary px-4 rounded-3">
                                    {{ __('messages.update') }}
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
    .dark-page {
        background: #0b1220;
        min-height: calc(100vh - 70px);
    }

    .dark-card {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .dark-input {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #fff !important;
    }

    .dark-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: none !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        transition: 0.2s;
    }
</style>

@push('scripts')
<script>
    document.getElementById('editUserForm').addEventListener('submit', function() {
        showToast('Updating user...', 'info');
    });
</script>
@endpush

@endsection
