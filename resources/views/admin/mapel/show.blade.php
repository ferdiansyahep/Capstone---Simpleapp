@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                @if ($mapel)
                <div class="card-header bg-transparent">
                    <h1 style="font-weight: 600;">{{ $mapel->nama_mapel }} Kelas {{$mapel->kelas}}</h1>
                </div>
                <div class="card-body bg-transparent">
                    <a href="{{route('client.nilai')}}" class="btn bg-primary-dashboard px-5 text-light">Nilai</a>
                    @if ($mapel->category->isNotEmpty())
                    <ul class="mt-5 list-unstyled row">
                        @foreach ($mapel->category as $ujian)
                        <li class="col-md-12 shadow-md py-2 px-0 rounded-3 my-2 bg-gray-200">
                            <div class="d-flex justify-content-around align-items-center">
                                <span class="d-flex align-items-center">
                                    <img src="{{ asset('img/img3.png') }}" alt="" width="35px"
                                        class="rounded-circle me-2">
                                    <a href="{{ route('admin.questions.createQuestions', $ujian->id) }}"
                                        class="text-decoration-none text-dark">{{$ujian->name}}</a>
                                </span>
                                <span class="d-flex align-items-center">
                                    <img src="{{ asset('img/calendar.svg') }}" alt="icon-calendar" width="auto"
                                        class="me-2">
                                    {{ $ujian->tanggal_ujian }}
                                </span>
                                <span class="d-flex align-items-center">
                                    <img src="{{ asset('img/time.svg') }}" alt="icon-time" class="me-2">
                                    {{ $ujian->jam_mulai }} - {{ $ujian->jam_selesai }}
                                </span>
                                <a href="{{ route('admin.questions.createQuestions', $ujian->id) }}"
                                    class="text-decoration-none text-dark">
                                    <i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center mt-5">jadwal ujian belum tersedia</p>
                    @endif
                </div>
                @else
                <h2 class="text-center">Guru belum mendapat Mata Pelajaran.</h2>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <section class="ftco-section shadow-sm">
                <div class="calendar calendar-first rounded" id="calendar_first">
                    <div class="calendar_header">
                        <button class="switch-month switch-left"> <i class="fa fa-chevron-left"></i></button>
                        <h2></h2>
                        <button class="switch-month switch-right"> <i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar_weekdays"></div>
                    <div class="calendar_content"></div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection