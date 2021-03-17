<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function listar()
    {
        return User::all();
    }
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
    }
    public function update(Request $request, User $idUser)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$idUser->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        // validar si la contraseña es vacia
        if (empty($request->password))
        {
            $data['password'] = $idUser->password;
        }else{
            $data['password'] = Hash::make($data['password']);
        }
        $idUser->update($data);
    }
    public function delete(User $idUser)
    {
        $idUser->delete();
    }
}
