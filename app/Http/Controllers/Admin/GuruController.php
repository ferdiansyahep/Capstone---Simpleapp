<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Category;
use App\Models\Mapel;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kelas)
    {
        $users = User::whereHas('roles', function ($query) {
        $query->where('title', 'Guru');
        })->where('kelas', $kelas)->with('mapel')->get();

    // Mengirim data pengguna dan mata pelajaran ke view
        return view('admin.guru.index', compact('users', 'kelas'));
    }


    public function create() 
    {
        $roles = Role::pluck('title', 'id');

        return view('admin.guru.create', compact('roles'));
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id); // Pastikan ini mendapatkan data guru
        $roles = Role::all()->pluck('name', 'id'); // Pastikan ini mendapatkan data role
        return view('admin.guru.edit', compact('user', 'roles'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated() + ['password' => bcrypt($request->password)]);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.guru.index')->with([
            'message' => 'User successfully updated!',
            'alert-type' => 'info'
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.guru.show', compact('user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index')->with([
            'message' => 'Guru successfully created!',
            'alert-type' => 'success'
        ]);
    }

    public function daftarNilai() {
        $user = Auth::user();
        $categories = Category::where('user_id', $user->id)->with(['results', 'mapel'])->get();
        return view('admin.guru.nilai', compact('categories'));
    }

    public function myClass()
    {
        $user = auth()->user();
        $mapel = Mapel::where('user_id', $user->id)->first();

        return view('admin.mapel.show', compact('mapel'));
    }
}