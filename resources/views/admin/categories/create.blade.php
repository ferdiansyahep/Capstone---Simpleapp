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
                <h1 class="fw-heading">{{ __('Tambah Jadwal Ujian') }}</h1>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">{{ __('Judul ujian') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="{{ __('Judul Ujian') }}"
                            name="name" value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mapel_id" class="col-sm-3 col-form-label">{{ __('Mata Pelajaran') }}</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="mapel_id" id="mapel_id">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapels as $id => $mapel)
                            <option value="{{ $id }}">{{ $mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal_ujian" class="col-sm-3 col-form-label">{{ __('Tanggal mulai') }}</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="tanggal_ujian" id="tanggal_ujian">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jam_mulai" class="col-sm-3 col-form-label">{{ __('Jam mulai') }}</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" name="jam_mulai" id="jam_mulai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jam_selesai" class="col-sm-3 col-form-label">{{ __('Jam selesai') }}</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode_ujian" class="col-sm-3 col-form-label">{{ __('Kode Ujian') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="kode_ujian" id="kode_ujian"
                            placeholder="kode ujian">
                    </div>
                </div>
                <div class="form-group row mb-5">
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
                <div class="form-group row mt-5">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{ route('admin.categories.index') }}"
                            class="btn btn-danger mx-2">{{ __('Batal') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Content Row -->

</div>
@endsection