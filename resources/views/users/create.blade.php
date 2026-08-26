@extends('layouts.app')

@section('content')

<div class="dark-page d-flex align-items-center justify-content-center py-4">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg rounded-4 dark-card">

                    <div class="card-header border-0 text-center bg-transparent pt-4 pb-2">

                        <h3 class="fw-bold text-light mb-1">
                            {{ __('messages.create_user') }}
                        </h3>

                        <small class="text-secondary">
                            Create user quickly
                        </small>

                    </div>

                    <div class="card-body px-4 py-3">

                        <form method="POST" action="{{ route('users.store') }}" id="createUserForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label text-light">{{ __('messages.name') }}</label>
                                <input type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control dark-input"
                                    placeholder="Enter name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-light">{{ __('messages.email') }}</label>
                                <input type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control dark-input"
                                    placeholder="Enter email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-light">{{ __('messages.status') }}</label>
                                <select name="status" class="form-select dark-input">
                                    <option value="active">{{ __('messages.active') }}</option>
                                    <option value="inactive">{{ __('messages.inactive') }}</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between mt-3">

                                <a href="{{ route('users.index') }}"
                                   class="btn btn-outline-light px-4 rounded-3">
                                    {{ __('messages.back') }}
                                </a>

                                <button type="submit" class="btn btn-success px-4 rounded-3">
                                    {{ __('messages.save') }}
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
        border: 1px solid rgba(255,255,255,0.08);
    }

    .dark-input {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #fff !important;
    }

    .dark-input:focus {
        border-color: #22c55e !important;
        box-shadow: none !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        border: none;
    }

    .btn-success:hover {
        transform: translateY(-1px);
        transition: 0.2s;
    }
</style>

@push('scripts')
<script>
    document.getElementById('createUserForm').addEventListener('submit', function() {
        showToast('Creating user...', 'info');
    });
</script>
@endpush

@endsection
