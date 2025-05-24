<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logout();

        return response('you are now logged out', 200);
    }

    // User
    public function userRegister(Request $req)
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

    public function userLogin(Request $req)
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

    // Administrateurt
    public function adminRegister(Request $req)
    {
        $data = $req->all();

        $rules = [
            'firstname' => ['required', 'max:255'],
            'lastname'  => ['required', 'max:255'],
            'email'     => ['required', 'email', 'unique:administrateurs'],
            'password'  => ['required', 'min:8'],
            'cin'     => ['required', 'unique:administrateurs'],
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $admin            = new Administrateur();
            $admin->firstname = $req->firstname;
            $admin->lastname  = $req->lastname;
            $admin->cin     = $req->cin;
            $admin->email     = $req->email;
            $admin->password  = Hash::make($req->password);

            $admin->save();

            return response("Admin created successfully", 200);
        }
    }

    public function adminLogin(Request $req)
    {
        $rules = [
            'cin'     => ['required', 'exists:administrateurs,cin'],
            'password' => ['required', 'min:8'],
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response($validator->errors()->first(), 422);
        }

        $admin = Administrateur::where('cin', $req->cin)->first();

        if (!$admin || !Hash::check($req->password, $admin->password)) {
            return response('Admin introuvable', 404);
        }

        $token = $admin
            ->createToken($admin->name)
            ->plainTextToken;

        return response([
            'token' => $token,
            'administrateur'  => $admin,
        ], 200);
    }
}
