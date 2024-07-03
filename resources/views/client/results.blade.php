@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Hasil Ujian</h3>
                </div>
                <div class="card-body">
                    @if($results->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Judul Ujian</th>
                                <th>Skor</th>
                                <th>Tanggal Ujian</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                            <tr>
                                <td>{{ $result->category->name }}</td>
                                <td>{{ $result->score }}</td>
                                <td>{{ $result->created_at->format('d-m-Y H:i') }}</td>
                                <td><a href="{{ route('admin.categories.results', $result->category->id) }}" class="btn btn-primary">Detail</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Tidak ada hasil ujian yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection