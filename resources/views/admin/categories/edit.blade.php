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
    <div class="container">
        <div class="card-header bg-transparent">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h2 class="mb-0 fw-heading">{{ __('Edit Ujian') }}</h2>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('put')

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">{{ __('Nama') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="{{ __('Nama') }}"
                            name="name" value="{{ old('name', $category->name) }}" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="mapel_id" class="col-sm-3 col-form-label">{{ __('Mata Pelajaran') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="mapel_id" id="mapel_id">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapels as $id => $mapel)
                            <option value="{{ $id }}" {{ $id == $category->mapel_id ? 'selected' : '' }}>{{ $mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_ujian" class="col-sm-3 col-form-label">{{ __('Tanggal Ujian') }}</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="tanggal_ujian" id="tanggal_ujian"
                            value="{{ old('tanggal_ujian', $category->tanggal_ujian) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jam_mulai" class="col-sm-3 col-form-label">{{ __('Jam Mulai') }}</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" name="jam_mulai" id="jam_mulai"
                            value="{{ old('jam_mulai', $category->jam_mulai) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jam_selesai" class="col-sm-3 col-form-label">{{ __('Jam Selesai') }}</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai"
                            value="{{ old('jam_selesai', $category->jam_selesai) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_id" class="col-sm-3 col-form-label">{{ __('Guru Pengampu') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="user_id" id="user_id">
                            @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ $id == $category->user_id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label for="kode_ujian" class="col-sm-3 col-form-label">{{ __('Kode Ujian') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="kode_ujian" placeholder="{{ __('Nama') }}"
                            name="kode_ujian" value="{{ old('kode_ujian', $category->kode_ujian) }}" />
                    </div>
                </div>

                <div class="form-group row mt-5">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-danger mx-2">{{ __('Batal') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Content Row -->

</div>
@endsection
