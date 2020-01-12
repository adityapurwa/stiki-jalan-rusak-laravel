<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = User::query()->where('email', '=', $request->get('email'))->firstOrFail();
            Auth::login($user);
            return [
                'user' => $user
            ];
        } else {
            return response([
                'login' => 'Invalid email or password'
            ], 400);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::query()->make([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
        ]);
        $user->password = bcrypt($request->get('password'));
        $user->save();
        Auth::login($user);
        return [
            'user' => $user
        ];

    }
}
