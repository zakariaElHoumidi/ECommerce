<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $data = $req->all();

        $rules = [
            'firstname' => ['required', 'max:255'],
            'lastname'  => ['required', 'max:255'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required', 'min:8'],
            'address'     => ['nullable', 'max:255'],
            'city'     => ['nullable', 'max:255'],
            'phone'     => ['nullable', 'digits:10', 'starts_with:0', 'unique:users'],
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $user            = new User();
            $user->firstname = $req->firstname;
            $user->lastname  = $req->lastname;
            $user->address     = $req->address;
            $user->city     = $req->city;
            $user->phone     = $req->phone;
            $user->email     = $req->email;
            $user->password  = Hash::make($req->password);

            $user->save();

            return response("User created successfully", 200);
        }
    }

    public function login(Request $req)
    {
        $rules = [
            'email'     => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:8'],
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response($validator->errors()->first(), 422);
        }

        $check = Auth
            ::attempt([
                'email' => $req->email,
                'password' => $req->password
            ]);

        if ($check) {
            $user  = Auth::user();
            $token = $user
                ->createToken($user->name)
                ->plainTextToken;

            return response([
                'token' => $token,
                'user'  => $user,
            ], 200);
        }

        return response('User introuvable', 404);
    }

    public function logout()
    {
        Auth::logout();

        return response('you are now logged out', 200);
    }
}
