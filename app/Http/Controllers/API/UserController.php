<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Lakukan validasi
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'about' => ['required', 'string', 'max:255' ],
                'password' => ['required', 'string', new Password],
            ]);

            // Buat akun user
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'about' => $request->about,
                'password' => Hash::make($request->password),
            ]);

            // ambil berdasarkan email
            $user = User::where('email', $request->email)->first();

            // jika sudah terdaftar mengembalikan token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Kembalikan respone jika sukess
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'User Registered');

            //jika gagal maka akan di tangkap Exception
        } catch (Exception $error){
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' =>$error,
            ],'Authentication Failed', 500);

        }
    }
}
