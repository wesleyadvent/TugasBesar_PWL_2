@extends('layouts.app2')

@section('content')
    <div class="container-fluid py-2">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Users Table</h6>
                        </div>
                    </div>
                    <div class="card-body px-4 pt-4">

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('warning'))
                            <div class="alert alert-warning">{{ session('warning') }}</div>
                        @endif

                        <form action="{{ route('administrator.users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label"></label>
                                        <select name="role" class="form-control" required>
                                            <option value="" hidden {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}" {{ old('Pilih Role') == $role ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label"></label>
                                        <select name="status" class="form-control" required>
                                            <option value="" hidden {{ old('status') ? '' : 'selected' }}>Pilih Status
                                            </option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}" {{ old('Pilih Status') == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                     <div class="d-flex justify-content-between">
                                        <a href="{{ route('administrator.users.index') }}"
                                            class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                            </div>
                        </form>

                    </div>
@endsection