@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="header"><h2>{{ __('Daftar Mata Pelajaran') }}</h2></div>
            <hr>
            <div class="body">
                <div class="row">
                    @forelse($siswa->mapels as $mapel)
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h6 class="text-light"><a href="{{ route('admin.mapel.show', $mapel->id) }}" class="text-light">{{ $mapel->nama_mapel }}</a></h6>
                                <span class="badge badge-pill badge-info">{{ $mapel->level }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <p>{{ __('Siswa ini belum mengambil mata pelajaran.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-right">
                <a href="{{ route('admin.siswa.addSubject', $siswa) }}" class="btn btn-primary">
                    {{ __('Tambah Mata Pelajaran') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
