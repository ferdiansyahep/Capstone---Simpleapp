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
                <h2 class="mb-0 fw-heading">{{ __('Edit Mata Pelajaran') }}</h2>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="nama_mapel" class="col-sm-3 col-form-label">{{ __('Nama mata pelajaran') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_mapel"
                            placeholder="{{ __('Nama mata pelajaran') }}" name="nama_mapel"
                            value="{{ old('nama_mapel', $mapel->nama_mapel) }}" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kelas" class="col-sm-3 col-form-label">{{ __('Kelas') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="kelas" name="kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="7" {{ $mapel->kelas == 7 ? 'selected' : '' }}>{{ __('7') }}</option>
                            <option value="8" {{ $mapel->kelas == 8 ? 'selected' : '' }}>{{ __('8') }}</option>
                            <option value="9" {{ $mapel->kelas == 9 ? 'selected' : '' }}>{{ __('9') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_id" class="col-sm-3 col-form-label">{{ __('Guru Pengampu') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="user_id" id="user_id">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $id => $nama)
                            <option value="{{ $id }}" {{ $mapel->user_id == $id ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label for="kode_mapel" class="col-sm-3 col-form-label">{{ __('Kode Kelas') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="kode_mapel" placeholder="{{ __('Kode mapel') }}"
                            name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" />
                    </div>
                </div>

                <div class="form-group row mt-5">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{ route('admin.mapel.index') }}" class="btn btn-danger mx-2">{{ __('Batal') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Content Row -->

</div>
@endsection