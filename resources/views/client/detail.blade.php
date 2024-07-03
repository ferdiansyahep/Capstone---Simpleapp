@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<div class="container">
    <div class="row mx-2">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body mx-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 style="font-weight: 500;" class="my-3">{{ $category->name }}</h2>
                        <button class="btn btn-outline-dark btn-md" disabled>{{ $totalScore }} / 100</button>
                    </div>
                    @can('question_create')
                    <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                        Buat Soal
                    </a>
                    @endcan
                    <table>
                        <tbody>
                            <tr>
                                <td scope="col">Mata Pelajaran</td>
                                <td scope="col">: {{ $category->mapel->nama_mapel }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $category->mapel?->kelas }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Ujian</td>
                                <td>: {{ $tanggal }}</td>
                            </tr>
                            <tr>
                                <td>Waktu Ujian</td>
                                <td>: {{ $category->jam_mulai }} - {{ $category->jam_selesai }} WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mx-2">
        <div class="col-md-9">
            @if($questions->isNotEmpty())
            @php
            $currentQuestionIndex = request()->get('question', 0);
            if (isset($questions[$currentQuestionIndex])) {
            $question = $questions[$currentQuestionIndex];
            }
            @endphp
            @if(isset($question))
            <form id="answer-form" action="" method="POST">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        <div class="d-block">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-outline-dark btn-sm" disabled>
                                        <strong>Soal No.{{ $currentQuestionIndex + 1 }} </strong>
                                    </button>
                                    @if(isset($selectedAnswers[$question->id]) &&
                                    !$selectedAnswers[$question->id]->is_correct)
                                    <button class="btn btn-danger btn-sm ms-2">X Salah</button>
                                    @endif
                                </div>
                                @if(isset($selectedAnswers[$question->id]) &&
                                    !$selectedAnswers[$question->id]->is_correct)
                                <button class="btn btn-outline-dark btn-sm ml-auto" disabled>
                                    <strong>0 / {{ $pointQuestion }}</strong>
                                </button>
                                @else
                                <button class="btn btn-outline-dark btn-sm ml-auto" disabled>
                                    <strong>{{ $pointQuestion }} / {{ $pointQuestion }}</strong>
                                </button>
                                @endif
                            </div>

                            <p class="mt-3">{{ $question->question_text }}</p>
                            <div>
                                @can('question_delete')
                                <form onsubmit="return confirm('Are you sure?')"
                                    action="{{ route('admin.questions.destroy', $question->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                                @endcan
                            </div>
                        </div>
                        <ul class="list-unstyled">
                            @foreach ($question->options as $option)
                            <li class="mx-auto px-3">
                                <input type="radio" id="option{{ $currentQuestionIndex }}{{ $loop->index }}"
                                    name="answer" value="{{ $option->id }}" @if(isset($selectedAnswers[$question->id])
                                && $selectedAnswers[$question->id]->selected_option_id == $option->id)
                                checked @endif>
                                <label
                                    for="option{{ $currentQuestionIndex }}{{ $loop->index }}">{{ $option->option_text }}</label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        @if($currentQuestionIndex > 0)
                        <a href="{{ route('admin.categories.results', ['category' => $category->id, 'question' => $currentQuestionIndex - 1]) }}"
                            class="btn bg-primary-dashboard text-light">Kembali</a>
                        @endif
                        <span class="ms-2 text-gray-500">{{ $currentQuestionIndex + 1 }} dari {{ $countQuestion }}
                            soal</span>
                        @if($currentQuestionIndex < $questions->count() - 1)
                            <a href="{{ route('admin.categories.results', ['category' => $category->id, 'question' => $currentQuestionIndex + 1]) }}"
                                class="btn bg-primary-dashboard text-light ms-2">Selanjutnya</a>
                            @endif
                    </div>
                    @can('siswa_access')
                    <div>
                        @if($currentQuestionIndex === $questions->count() - 1)
                        <button type="submit" name="finish" class="btn btn-success me-2">Selesai</button>
                        @endif
                    </div>
                    @endcan
                </div>
            </form>
            @else
            <p>Indeks pertanyaan tidak valid.</p>
            @endif
            @else
            <p>Tidak ada pertanyaan yang tersedia.</p>
            @endif
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            @foreach($questions as $index => $q)
                            <div class="col-4 mb-3">
                                <li
                                    class="list-group-item text-center rounded-3 {{ isset($selectedAnswers[$q->id]) ? 'bg-success-dashboard' : 'bg-secondary-custom' }}">
                                    <a href="{{ route('admin.categories.results', ['category' => $category->id, 'question' => $index]) }}"
                                        class="text-dark text-decoration-none">{{ $index + 1 }}</a>
                                </li>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="container px-3 mt-3">
                        <div class="row">
                            <div class="col-2">
                                <div class="box bg-success-dashboard rounded-3" style="width: 25px; height: 25px;">
                                </div>
                            </div>
                            <div class="col-10 mb-2">
                                <span>Sudah dikerjakan</span>
                            </div>
                            <div class="col-2">
                                <div class="box bg-secondary-custom rounded-3" style="width: 25px; height: 25px;"></div>
                            </div>
                            <div class="col-10">
                                <span>Belum dikerjakan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection