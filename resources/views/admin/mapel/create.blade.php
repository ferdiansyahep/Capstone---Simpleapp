@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container">
        <div class="card-header bg-transparent">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="fw-heading">{{ __('Mata pelajaran') }}</h1>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="nama_mapel" class="col-sm-3 col-form-label">{{ __('Nama mata pelajaran') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_mapel"
                            placeholder="{{ __('Nama mata pelajaran') }}" name="nama_mapel"
                            value="{{ old('nama_mapel') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kelas" class="col-sm-3 col-form-label">{{ __('Kelas') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="kelas" name="kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="7">{{ __('7') }}</option>
                            <option value="8">{{ __('8') }}</option>
                            <option value="9">{{ __('9') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user_id" class="col-sm-3 col-form-label">{{ __('Guru Pengampu') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="user_id" id="user_id">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode_mapel" class="col-sm-3 col-form-label">{{ __('Kode Kelas') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="kode_mapel" placeholder="{{ __('Kode mapel') }}"
                            name="kode_mapel" value="{{ old('kode_mapel') }}" />
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
</div>
@endsection
