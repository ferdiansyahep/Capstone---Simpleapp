<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ResultController extends Controller
{
    public function show($result_id){
        abort_if(Gate::denies('result_access'), Response::HTTP_FORBIDDEN, 'Akses tidak diizinkan');
        $result = Result::whereHas('user', function ($query) {
            $query->whereId(auth()->id());
        })->findOrFail($result_id);
    
        return view('client.results', compact('result'));
    }
}
