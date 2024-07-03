@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Kode Mapel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $mataPelajaran->nama_mapel }}</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
