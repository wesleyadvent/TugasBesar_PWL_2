@extends('layouts.app2')

@section('content')

    <div class="container-fluid py-2">

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

                        <form action="{{ route('administrator.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label text-dark">Nama</label>
                                    <div class="input-group input-group-outline my-0">
                                        <label class="form-label"></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="name" class="text-dark form-label">Email</label>
                                    <div class="input-group input-group-outline my-0">
                                        <label class="form-label"></label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password" class="text-dark form-label">Password <small
                                            class="text-dark">(Kosongkan jika
                                            tidak ingin mengganti)</small></label>
                                    <div class="input-group input-group-outline my-0">
                                        <label class="form-label"></label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-dark">Konfirmasi Password</label>
                                    <div class="input-group input-group-outline my-0">
                                        <label class="form-label"></label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation">
                                    </div>
                                </div>
                            </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="role" class="form-label text-dark">Role</label>
                                        <div class="input-group input-group-static mb-4">
                                            <label for="exampleFormControlSelect1" class="ms-0"></label>
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}" @selected(old('role', $user->role) == $role)>
                                                        {{ ucfirst($role) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="status" class="text-dark form-label">Status</label>
                                        <div class="input-group input-group-static mb-4">
                                            <label for="exampleFormControlSelect1" class="ms-0"></label>
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status }}" @selected(old('status', $user->status) == $status)>{{ ucfirst($status) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('administrator.users.index') }}"
                                            class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection