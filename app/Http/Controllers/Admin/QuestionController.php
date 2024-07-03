<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\QuestionRequest;
use App\Models\Category;
use App\Models\Mapel;
use App\Models\Option;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN,'Akses tidak diizinkan');
        $questions = Question::with('category', 'options')->get(); // Pastikan untuk memuat relasi
        return view('admin.questions.index', compact('questions'));
    }

    public function create($id): View
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN,'Akses tidak diizinkan');
        $categories = Category::find($id);
        $listQuestion = Question::where('category_id', $id)->get();
        $numberOfQuestions = Question::where('category_id', $id)->count();
        $nextQuestionNumber = $numberOfQuestions + 1;

        if ($numberOfQuestions > 0) {
            $calculatePointQuestion = 100 / $numberOfQuestions;
        } else {
            $calculatePointQuestion = 0;
        }

        return view('admin.questions.create', compact('categories', 'id','listQuestion', 'nextQuestionNumber', 'calculatePointQuestion'));
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:3', // Minimal dua jawaban
            'options.*' => 'required|string', // Pastikan setiap opsi adalah string yang valid
            'correct_option' => 'required|integer', // Validasi untuk memastikan nilai yang dikirimkan adalah integer (indeks opsi)
        ]);

    // Simpan pertanyaan
        $question = Question::create([
            'question_text' => $request->input('question_text'),
            'category_id' => $request->input('category_id'),
        ]);

    // Simpan jawaban
        foreach ($request->input('options') as $key => $option) {
            $isCorrect = $key == $request->input('correct_option');
            Option::create([
                'question_id' => $question->id,
                'option_text' => $option,
                'is_correct' => $isCorrect,
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Successfully created!',
            'alert-type' => 'success'
        ]);
    }



    public function show(Question $question): View
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $categories = Category::all()->pluck('name', 'id');
        $listQuestion = Question::where('category_id', $question->category_id)->get();
        $numberOfQuestions = Question::where('category_id', $question->category_id)->count();

        $index = $listQuestion->search(function ($item) use ($question) {
            return $item->id == $question->id;
        });
        
        $nextQuestionNumber = $index + 1;

        if ($numberOfQuestions > 0) {
            $calculatePointQuestion = 100 / $numberOfQuestions;
        } else {
            $calculatePointQuestion = 0;
        }

        return view('admin.questions.edit', compact('question', 'categories', 'listQuestion', 'calculatePointQuestion', 'nextQuestionNumber'));
    }



    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $question = Question::findOrFail($id);

        $question->update([
            'question_text' => $request->input('question_text'),
            'category_id' => $request->input('category_id'),
        ]);

    // Hapus opsi yang udah ada
        $question->options()->delete();

        foreach ($request->input('options') as $index => $optionText) {
            $isCorrect = $request->input('correct_option') == $index;

            Option::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct' => $isCorrect,
            ]);
        }

        return redirect()->route('admin.questions.index')->with([
            'message' => 'Successfully updated!',
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Question $question): RedirectResponse
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN,'Akses tidak diizinkan');
        $question->delete();

        return redirect()->route('admin.questions.createQuestions', $question->category->id)->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Question::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    public function answer(Request $request, Question $question)
    {
        $answer = $request->input('answer');
        session(['answer.' . $question->id => $answer]);

        return redirect()->route('admin.categories.show', ['category' => $question->category_id, 'question' => request()->get('question', 0)]);
    }

    public function endTest(Request $request)
    {
    
        $request->validate([
        ]);

        $questions = session('questions');
        $answers = session('answers', []);
        $totalQuestions = count($questions);
        $correctAnswers = 0;

        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] == $question->correct_option_id) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        Result::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'score' => $score,
        ]);

        session()->forget('answers');
        session()->forget('questions');

        return redirect()->route('beranda')->with('status', 'Ujian selesai');
    }


    public function showResults()
    {
        $results = Result::with('category')->where('user_id', Auth::id())->get();
        return view('admin.results.index', compact('results'));
    }

    public function createQuestions($id)
    {
        $categories = Category::all()->pluck('name', 'id');
        $mapel = Category::findOrFail($id);

        // Kirim ID kategori yang dipilih ke tampilan
        return view('admin.questions.createQuestions', compact('categories', 'mapel', 'id'));
    }
}
