<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 2,
            'foto' => '/img/user.jpg',
        ]);;

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([ 
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        $user = User::findOrFail($id);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
    
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data);
    
        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return response(null, 204);
    }

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

   public function updateProfil(Request $request)
{
    $user = auth()->user();
    $user->name = $request->name;

    // Handle password update
    if ($request->filled('password')) {
        $this->validatePasswordUpdate($request, $user);
        $user->password = bcrypt($request->password);
    }

    // Handle photo upload
    if ($request->hasFile('foto')) {
        $user->foto = $this->storeProfilePhoto($request->file('foto'));
    }

    $user->save();

    return response()->json($user);
}

/**
 * Validate password update request
 */
protected function validatePasswordUpdate(Request $request, $user)
{
    $request->validate([
        'old_password' => 'required|current_password',
        'password' => 'required|confirmed|min:8'
    ], [
        'old_password.current_password' => 'Password lama tidak sesuai',
        'password.confirmed' => 'Konfirmasi password tidak sesuai'
    ]);
}

/**
 * Store profile photo and return path
 */
protected function storeProfilePhoto($file)
{
    $nama = 'logo-' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('/img'), $nama);
    return "/img/$nama";
}
}
