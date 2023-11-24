<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        try {
            $input = $request->all();
            $validate = Validator::make($input, [
                'username' => 'required',
                'password' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phoneNumber' => 'required',
                'address' => 'required',
                'bornDate' => 'required',
                'photo' => 'required'
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

            // $fileName = $_FILES["photo"]["name"];
            // $tmpName = $_FILES["photo"]["tmp_name"];
            // move_uploaded_file($tmpName, $fileName);
            // $input['photo'] = $fileName;

            $user = User::create($input);
            return response()->json([
                'message' => 'Berhasil menambahkan data user',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $loginData = $request->all();

            $validate = Validator::make($loginData, [
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }
            $user = User::where('username', $loginData['username'])->where('password', $loginData['password'])->first();
            if (!$user) {
                return response()->json([
                    'message' => 'Username atau password salah',
                    'data' => [],
                ], 404);
            }
            return response()->json([
                'message' => 'Berhasil login',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
    public function updatePassword(Request $request, String $email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'Email tidak ditemukan',
                    'data' => [],
                ], 404);
            }
            $input = $request->all();
            $validate = Validator::make($input, [
                'password' => 'required',
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }
            $user->password = $input['password'];
            $user->save();
            return response()->json([
                'message' => 'Berhasil mengubah password',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function getImageLink(String $filename)
    {
        try {
        $imageUrl = asset('images/' . $filename);
        return response()->json(['data' => $imageUrl]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'Data user tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data user dengan nama ' . $user->name . '',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'Data user tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            $input = $request->all();
            $validate = Validator::make($input, [
                'username' => 'required',
                'password' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phoneNumber' => 'required',
                'address' => 'required',
                'bornDate' => 'required',
                'photo' => 'required|mimes:jpeg,jpg,png,',
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

            $fileName = $_FILES["photo"]["name"];
            $tmpName = $_FILES["photo"]["tmp_name"];

            $destinationPath = public_path('images/');
            $uploadedFilePath = $destinationPath . $fileName;

            move_uploaded_file($tmpName, $uploadedFilePath);
            $input['photo'] = $fileName;

            $user->update($input);

            return response()->json([
                'message' => 'Berhasil mengubah data user',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}
