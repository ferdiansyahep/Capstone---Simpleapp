@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Content Row -->
    <div class="card shadow">
        <div class="card-header bg-transparent">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ __('Create User') }}</h1>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="{{ __('Name') }}" name="name"
                            value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" placeholder="{{ __('Email') }}" name="email"
                            value="{{ old('email') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nomer_induk" class="col-sm-3 col-form-label">{{ __('Nomer Induk') }}</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="nomer_induk" placeholder="{{ __('Nomer Induk') }}"
                            name="nomer_induk" value="{{ old('nomer_induk') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal_lahir" class="col-sm-3 col-form-label">{{ __('Tanggal Lahir') }}</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="tanggal_lahir" placeholder="{{ __('Tanggal Lahir') }}"
                            name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis_kelamin" class="col-sm-3 col-form-label">{{ __('Jenis Kelamin') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">-- Pilih jenis kelamin --</option>
                            <option value="Laki-laki">{{ __('Laki-laki') }}</option>
                            <option value="Perempuan">{{ __('Perempuan') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kelas" class="col-sm-3 col-form-label">{{ __('Kelas') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="kelas" name="kelas" required>
                            <option value="">-- Pilih kelas --</option>
                            <option value="7">{{ __('7') }}</option>
                            <option value="8">{{ __('8') }}</option>
                            <option value="9">{{ __('9') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">{{ __('Password') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="password" placeholder="{{ __('Password') }}"
                            name="password" value="{{ old('password') }}" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="roles" class="col-sm-3 col-form-label">{{ __('Role') }}</label>
                    <div class="col-sm-9">
                        <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                            @foreach($roles as $id => $roles)
                            <option value="{{ $id }}"
                                {{ (in_array($id, old('roles', [])) || isset($role) && $role->roles->contains($id)) ? 'selected' : '' }}>
                                {{ $roles }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-5">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-danger mx-2">{{ __('Batal') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Content Row -->
</div>
@endsection
