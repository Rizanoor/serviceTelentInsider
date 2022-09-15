<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



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

    public function login(Request $request)
    {
        try {
            // membuat validasi ketika login
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            // cek apakah email dan password benar atau tidak
            if (!Auth::attempt($credentials)) {
                // jika gagal maka kembalikan response error
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ],'Authentication Failed', 500);
            }

            // jika berhasil maka lanjut ke blok ini dan ambil data yang paling pertama
            $user = User::where('email', $request->email)->first();
            // cek password apakah sudah sesuai atau belum
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            // jika berhasil maka akan mendapatkan token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            // jika sudah kembalikan response success
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'Authenticated');

            // jika gagal maka akan kembalikan exception
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }

    // Ambil data user
    public function fetch(Request $request)
    {
        // kembalikan respponse successs
        return ResponseFormatter::success($request->user(),'Data profile user berhasil diambil');
    }

    // Update profile user
    public function updateProfile(Request $request)
    {
        // simpan data user
        $data = $request->all();

        // ambil data user yang sedang login
        $user = Auth::user();
        // data user diupdate
        $user->update($data);

        // jalankan response dan kembalikan sukses bersama dengan pesannya
        return ResponseFormatter::success($user,'Profile Updated');
    }

    public function logout(Request $request)
    {
        // abil tokern user yang sedang login dan hapus
        $token = $request->user()->currentAccessToken()->delete();

        // kembalikan respons
        return ResponseFormatter::success($token,'Token Revoked');
    }
}
