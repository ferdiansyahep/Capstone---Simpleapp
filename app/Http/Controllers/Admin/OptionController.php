<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\OptionRequest;
use App\Models\Question;

class OptionController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('option_access'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $options = Option::all();

        return view('admin.options.index', compact('options'));
    }

    public function create(): View
    {
        abort_if(Gate::denies('option_create'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $questions = Question::all()->pluck('question_text', 'id');

        return view('admin.options.create', compact('questions'));
    }

    public function store(OptionRequest $request): RedirectResponse
    {
        abort_if(Gate::denies('option_create'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        foreach ($request->input('options') as $option) {
            $isCorrect = $request->input('correct_option') == $option; // Mengatur jawaban yang benar
            Option::create([
                'question_id' => $questions->id,
                'option' => $option,
                'is_correct' => $isCorrect,
            ]);
        }
        

        return redirect()->route('admin.options.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Option $option): View
    {
        return view('admin.options.show', compact('option'));
    }

    public function edit(Option $option): View
    {
        abort_if(Gate::denies('option_edit'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $questions = Question::all()->pluck('question_text', 'id');

        return view('admin.options.edit', compact('option', 'questions'));
    }

    public function update(OptionRequest $request, Option $option): RedirectResponse
    {
        abort_if(Gate::denies('option_edit'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $option->update($request->validated());

        return redirect()->route('admin.options.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Option $option): RedirectResponse
    {
        abort_if(Gate::denies('option_delete'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $option->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Option::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
