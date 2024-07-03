<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Category;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index($kelas)
    {
        $users = User::whereHas('roles', function ($query) {
        $query->where('title', 'Siswa');})->where('kelas', $kelas)->get();
        return view('admin.siswa.index', compact('users', 'kelas'));
    }

    public function create() {
        $roles = Role::pluck('title', 'id');

        return view('admin.siswa.create', compact('roles'));
    }

    public function show(User $siswa)
    {
        $siswa->load('mapels'); 
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.siswa.edit', compact('user', 'roles'));
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

        return redirect()->route('admin.siswa.index')->with([
            'message' => 'User successfully updated!',
            'alert-type' => 'info'
        ]);
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
            'message' => 'User successfully created!',
            'alert-type' => 'success'
        ]);
    }

    public function kelas()
    {
        $siswa = Auth::user();
        return view('admin.siswa.show', compact('siswa'));
    }

    public function hasilUjian() {
        $userId = Auth::id();
        $results = Result::where('user_id', $userId)->get();

        return view('client.results', compact('results'));
    }

    public function jadwalUjian()
    {
        Carbon::setLocale('id');
        $user = Auth::user();
        $kelas = $user->kelas;
        $results = Result::where('user_id', $user->id)->get();
        $category = Category::first();
        $ujian = Category::whereHas('mapel', function ($query) use ($kelas) {
            $query->where('kelas', $kelas);
        })->get();

        if ($category) {
            $categoryId = $category->id;
            $results = Result::where('user_id', $user->id)->where('category_id', $categoryId)->get();
            $ujian->each(function ($data) {
                $data->formatted_tanggal_ujian = Carbon::parse($data->tanggal_ujian)->translatedFormat('d F Y');
                            });
            return view('client.index', compact('ujian', 'results'));
        } else {
            return redirect()->back()->with('error', 'Category not found.');
        }
    }

    public function addSubject(User $siswa)
    {
        $mapels = Mapel::all()->groupBy('kelas');;
        return view('admin.siswa.addSubject', compact('siswa', 'mapels'));
    }

    public function storeSubject(Request $request, User $siswa)
    {
        $request->validate([
            'mapels' => 'required|array',
            'mapels.*' => 'exists:mapels,id',
        ]);

        $siswa->mapels()->attach($request->mapels);

        return redirect()->route('admin.siswa.show', $siswa)->with('success', 'Subjects added successfully');
    }
}