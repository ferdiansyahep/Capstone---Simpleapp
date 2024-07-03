@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header bg-transparent">
                <h2>{{ __('Ujian') }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($ujian as $data)
                    <div class="col-sm-3 mb-3">
                        <div class="card border-primary bg-transparent">
                            <div class="card-body">
                                <button class="btn btn-danger btn-sm mb-2 w-75"
                                    style="cursor: none;">{{ $data->formatted_tanggal_ujian }}</button>
                                <p class="my-2 fw-bold">{{ $data->mapel?->nama_mapel }}</p>
                                @php
                                $result = $results->firstWhere('category_id', $data->id);
                                @endphp
                                @if ($result)
                                <p class="mb-0 float-start">
                                    <a href="#" class="text-decoration-none text-dark open-modal" style="pointer-events: none;" data-toggle="modal"
                                        data-target="#examCodeModal{{ $data->id }}">{{ $data->name }}</a>
                                </p>
                                @else
                                <p class="mb-0 float-start">
                                    <a href="#" class="text-decoration-none text-dark open-modal" data-toggle="modal"
                                        data-target="#examCodeModal{{ $data->id }}">{{ $data->name }}</a>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="examCodeModal{{ $data->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="examCodeModalLabel{{ $data->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="examCodeModalLabel{{ $data->id }}">Masukkan Kode
                                        Ujian</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.categories.verify', $data->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exam_code">Kode Ujian</label>
                                            <input type="text" class="form-control" id="exam_code" name="exam_code"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Verifikasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                    @empty
                    <div class="col-md-12">
                        <p>{{ __('Jadwal Ujian Belum Tersedia.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection