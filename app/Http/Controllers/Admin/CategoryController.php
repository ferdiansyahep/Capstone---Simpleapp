<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\AnsweredQuestion;
use App\Models\Kelas;
use Carbon\Carbon;
use App\Models\Mapel;
use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('class_access'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $categories = Category::all();
        $users = User::all();

        return view('admin.categories.index', compact('categories', 'users'));
    }
    
    public function create()
    {
        abort_if(Gate::denies('class_create'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $guru = User::whereHas('roles', function ($query) {
            $query->where('title', 'guru');
        })->pluck('name', 'id');
        $mapels = Mapel::all()->pluck('nama_mapel', 'id');

        return view('admin.categories.create', compact('guru', 'mapels'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('class_create'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Request $request, $categoryId, $questionIndex = 0)
    {
        Carbon::setLocale('id');
        $category = Category::with('questions.options')->findOrFail($categoryId);
        $questions = $category->questions;
        $countQuestion = $questions->count();
        $tanggal = Carbon::parse($category->tanggal_ujian)->translatedFormat('d F Y');

        if ($countQuestion > 0) {
            $pointQuestion = 100 / $countQuestion;
        } else {
            $pointQuestion = 0;
        }
    
        if ($request->isMethod('post')) {
            $answers = $request->session()->get('answers', []);
            $answers[$request->question_id] = $request->answer;
            $request->session()->put('answers', $answers);

            if ($request->has('finish')) {
                return $this->finishExam($request, $category, $questions);
            }
            return redirect()->route('admin.categories.show', ['category' => $categoryId, 'question' => $questionIndex + 1]);
        }
        
        return view('admin.categories.show', compact('category', 'questions', 'countQuestion', 'pointQuestion', 'tanggal'));
    }

    public function edit(Category $category)
    {
        abort_if(Gate::denies('class_edit'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $users = User::all()->pluck('name', 'id');
        $mapels = Mapel::all()->pluck('nama_mapel', 'id');

        return view('admin.categories.edit', compact('category', 'users', 'mapels'));
    }

    public function update(Request $request, Category $category)
    {
        abort_if(Gate::denies('class_edit'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Category $category)
    {
        abort_if(Gate::denies('class_delete'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $category->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Category::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }


    public function finishExam(Request $request, $category, $questions)
    {
        $totalQuestions = $questions->count();
        $pointsPerQuestion = 100 / $totalQuestions;

        $answers = $request->session()->get('answers', []);
        $score = 0;

        foreach ($questions as $question) {
            if (isset($answers[$question->id])) {
                $selectedOptionId = $answers[$question->id];
                $selectedOption = $question->options->firstWhere('id', $selectedOptionId);

                if ($selectedOption) {
                    AnsweredQuestion::create([
                        'user_id' => Auth::id(),
                        'question_id' => $question->id,
                        'selected_option_id' => $selectedOptionId,
                        'is_correct' => $selectedOption->is_correct,
                    ]);

                    if ($selectedOption->is_correct) {
                        $score += $pointsPerQuestion;
                    }
                }
            }
        }

        try {
            Result::create([
                'user_id' => Auth::id(),
                'category_id' => $category->id,
                'score' => $score,
            ]);
            $request->session()->forget('answers');
            return redirect()->route('beranda')->with('status', 'Ujian selesai. Skor: ' . $score);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan hasil ujian: ' . $e->getMessage());
        }
    }

    public function verifyExamCode(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['valid' => false, 'message' => 'Kategori tidak ditemukan']);
        }

        if ($request->exam_code === $category->kode_ujian) {
            return redirect()->route('admin.categories.show', $category->id);
        } else {
            return redirect()->back()->with([
                'message' => 'Kode Ujian Salah!',
                'alert-type' => 'danger'
            ]);
        }
    }

    public function showResults($categoryId)
    {
        $userId = Auth::id();
        $results = Result::where('user_id', $userId)->get();
        $category = Category::with('mapel')->findOrFail($categoryId);
        $questions = Question::where('category_id', $categoryId)->get();
        $countQuestion = $questions->count();
        $tanggal = Carbon::parse($category->tanggal_ujian)->translatedFormat('d F Y');

        $results = Result::where('user_id', $userId)->where('category_id', $categoryId)->get();
        $totalScore = $results->sum('score');

        if ($countQuestion > 0) {
            $pointQuestion = 100 / $countQuestion;
        } else {
            $pointQuestion = 0;
        }

        $selectedAnswers = AnsweredQuestion::where('user_id', $userId)
            ->whereHas('question', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get()
            ->keyBy('question_id');

        return view('client.detail', compact('category', 'questions', 'pointQuestion', 'countQuestion', 'tanggal', 'totalScore', 'selectedAnswers'));
    }
}