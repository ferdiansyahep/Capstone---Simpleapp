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
        <h2 style="font-weight: 600px;" class="mb-3 float-start">{{$question->category->name}}</h2>
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
            <div class="float-end">
                @can('question_delete')
                <form onclick="return confirm('Are you sure?')"
                    action="{{ route('admin.questions.destroy', $question->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"
                            aria-hidden="true"></i></button>
                </form>
                @endcan
            </div>
            <form method="POST" action="{{ route('admin.questions.update', $question->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group required mt-2">
                    <label for="nomer-urut" class="control-label fw-bold">{{ __('Nomer Urut') }}</label>
                    <input type="text" class="form-control" id="question_text" placeholder="{{ __('question text') }}"
                        name="question_text" value="{{ $nextQuestionNumber }}" disabled />
                </div>
                <div class="form-group" hidden>
                    <label for="category">{{ __('Judul Ujian') }}</label>
                    <select class="form-control" name="category_id" id="category">
                        @foreach($categories as $id => $category)
                        <option value="{{ $id }}" @if($question->category_id == $id) selected @endif>{{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group required">
                    <label for="question_text" class="control-label fw-bold">{{ __('Pertanyaan') }}</label>
                    <textarea class="form-control" id="question_text" name="question_text"
                        placeholder="{{ __('question text') }}">{{ $question->question_text }}</textarea>
                </div>

                <div class="form-group required mb-4">
                    <label for="options" class="control-label fw-bold">{{ __('Opsi') }}</label>
                    <label for="" class="float-end text-gray-600">{{ __('Jawaban yang benar') }}</label>
                    <div id="options">
                        @foreach($question->options as $index => $option)
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0">{{ chr(65 + $index) }}</span>
                            </div>
                            <input type="text" class="form-control" name="options[]"
                                placeholder="option {{ $index + 1 }}" value="{{ $option->option_text }}">
                            <div class="input-group-append">
                                <div class="input-group-text bg-transparent border-0">
                                    <input type="radio" name="correct_option" value="{{ $index }}"
                                        @if($option->is_correct) checked @endif>
                                    <!-- Beri tanda checked jika opsi benar -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group required d-flex align-items-start justify-content-between mb-0">
                    <div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0 control-label fw-bold">Bobot
                                    Nilai</span>
                            </div>
                            <input type="text" name="" id="" class="form-control" style="width: 80px;" value="{{$calculatePointQuestion}}">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0">Dari</span>
                            </div>
                            <input type="text" name="" id="" class="form-control" style="width: 80px;" value="100">
                        </div>
                    </div>
                    <a href="{{ route('admin.questions.createQuestions', $question->category->id) }}"
                        class="btn bg-success-dashboard text-dark px-3 align-self-end">
                        <span class="icon text-dark"><i class="fa fa-plus-circle"></i></span> Tambah Soal
                    </a>
                    <button type="submit" class="position-absolute top-0 end-0 btn bg-primary-dashboard text-light"
                        style="margin-right: 30px; margin-top:70px;">Simpan soal</button>
                </div>
                <!-- <button type="button" class="btn btn-secondary" id="addoption">Add Another Option</button>
                <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('addoption').addEventListener('click', function () {
        var optionIndex = document.querySelectorAll('#options .input-group').length + 1;
        var newoption = `
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="options[]" placeholder="option ` + optionIndex + `">
            <div class="input-group-append">
                <div class="input-group-text">
                    <input type="radio" name="correct_option" value="` + optionIndex + `"> <!-- Value disesuaikan dengan indeks opsi -->
                </div>
            </div>
        </div>
    `;
        document.getElementById('options').insertAdjacentHTML('beforeend', newoption);
    });
</script>
@endsection