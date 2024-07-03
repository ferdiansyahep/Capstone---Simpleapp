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

    <div class="container row">
        <h2 style="font-weight: 600px;" class="mb-3 float-start">{{ $categories->name }}</h2>
    </div>
    <div class="mb-3">
        <div class="d-flex flex-wrap justify-content-start shadow-lg rounded-3 py-2">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent border-0 control-label fw-bold">Navigasi Soal</span>
            </div>
            @foreach($listQuestion as $index => $q)
            <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn btn-outline-primary m-1">
                {{ $index + 1 }}
            </a>
            @endforeach
        </div>
    </div>
    <div class="container shadow-lg rounded-3 bg-light">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.questions.store') }}">
                @csrf
                <div class="form-group required">
                    <label for="nomer-urut" class="control-label fw-bold">{{ __('Nomer Urut') }}</label>
                    <input type="text" class="form-control" name="number" id="" value="{{ $nextQuestionNumber }}"
                        disabled>
                </div>
                <div class="form-group" hidden>
                    <label for="category">{{ __('Judul Ujian') }}</label>
                    <input type="text" name="category_id_disabled" id="category" value="{{ $categories->id }}" disabled>
                    <input type="hidden" name="category_id" value="{{ $categories->id }}">
                </div>
                <div class="form-group required">
                    <label for="question_text" class="control-label fw-bold">{{ __('Pertanyaan') }}</label>
                    <textarea name="question_text" class="form-control" id="question_text"
                        placeholder="{{ __('Tulis pertanyaan........') }}"></textarea>
                </div>
                <div class="form-group required">
                    <label for="options" class="control-label fw-bold">{{ __('Opsi') }}</label>
                    <label for="" class="float-end text-gray-600">{{ __('Jawaban yang benar') }}</label>
                    <div id="options" class="d-flex flex-column">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0">A</span>
                                    </div>
                                    <input type="text" class="form-control" name="options[]" placeholder="">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-transparent border-0">
                                            <input type="radio" name="correct_option" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0">B</span>
                                    </div>
                                    <input type="text" class="form-control" name="options[]" placeholder="">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-transparent border-0">
                                            <input type="radio" name="correct_option" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0">C</span>
                                    </div>
                                    <input type="text" class="form-control" name="options[]" placeholder="">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-transparent border-0">
                                            <input type="radio" name="correct_option" value="2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0">D</span>
                                    </div>
                                    <input type="text" class="form-control" name="options[]" placeholder="">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-transparent border-0">
                                            <input type="radio" name="correct_option" value="3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group required d-flex align-items-start justify-content-between mb-0">
                    <div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0 control-label fw-bold">Bobot
                                    Nilai</span>
                            </div>
                            <input type="text" name="weight" id="weight" class="form-control" style="width: 80px;"
                                value="{{$calculatePointQuestion}}">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0">Dari</span>
                            </div>
                            <input type="text" name="max_weight" id="max_weight" class="form-control"
                                style="width: 80px;" value="100">
                        </div>
                    </div>
                    <button type="submit" class="btn bg-success-dashboard text-dark px-3 align-self-end">
                        <span class="icon text-dark"><i class="fa fa-plus-circle"></i></span> Tambah Soal
                    </button>
                    <button type="submit" class="position-absolute top-0 end-0 btn bg-primary-dashboard text-light"
                        style="margin-right: 30px; margin-top:70px;">Simpan soal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection