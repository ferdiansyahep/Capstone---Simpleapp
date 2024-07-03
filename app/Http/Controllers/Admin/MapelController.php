<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mapel;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MapelController extends Controller
{
    public function index($kelas): View
    {
        $mapels = Mapel::where('kelas', $kelas)->get();
        $user = User::all();
        return view('admin.mapel.index', compact('mapels', 'user', 'kelas'));
    }

    public function create(): View
    {
        $guru = User::whereHas('roles', function ($query) {
            $query->where('title', 'guru');
        })->pluck('name', 'id');
        
        
        return view('admin.mapel.create', compact('guru'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'kode_mapel' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);
        
        Mapel::create($request->all());

        return redirect()->back()->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Mapel $mapel): View
    {
        return view('admin.mapel.show', compact('mapel'));
    }

    public function edit(Mapel $mapel): View
    {
        $guru = User::whereHas('roles', function ($query) {
            $query->where('title', 'guru');
        })->pluck('name', 'id');

        return view('admin.mapel.edit', compact('mapel', 'guru'));
    }

    public function update(Request $request, Mapel $mapel): RedirectResponse
    {
        $mapel->update($request->all());

        return redirect()->back()->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Mapel $mapel): RedirectResponse
    {
        $mapel->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Mapel::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
