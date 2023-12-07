<?php

namespace App\Http\Controllers;

use App\Models\rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\transaction;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rating = Rating::all();

            if ($rating->count() == 0) {
                return response()->json([
                    'message' => 'Data rating tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data rating',
                'data' => $rating,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $validate = Validator::make($input, [
                'id_transaksi' => 'required',
                'stars' => 'required',
                'notes' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }


            $rating = Rating::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data rating',
                'data' => $rating,
            ], 200);
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
    public function show($iduser)
    {
        try {
            $user = User::find($iduser);
            if (!$user) {
                return response()->json([
                    'message' => 'Data user tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            $transaksi = transaction::where('id_user', $iduser)->get();
            if ($transaksi->isEmpty()) {
                return response()->json([
                    'message' => 'No transactions found for this user.',
                    'data' => [],
                ], 404);
            }

            $kumpulanRating = collect();

            foreach ($transaksi as $transaction) {
                $ratings = Rating::where('id_transaksi', $transaction->id)->get();
                $kumpulanRating = $kumpulanRating->merge($ratings);
            }

            if ($kumpulanRating->isEmpty()) {
                return response()->json([
                    'message' => 'No ratings found for the transactions of this user.',
                    'data' => [],
                ], 404);
            }



            return response()->json([
                'message' => 'Berhasil menampilkan data rating untuk pengguna dengan ID ' . $iduser,
                'data' => $kumpulanRating,
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
            $rating = Rating::find($id);

            $input = $request->all();
            $validate = Validator::make($input, [
                'id_transaksi' => 'required',
                'stars' => 'required',
                'notes' => 'required',
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

            $rating->id_transaksi = $input['id_transaksi'];
            $rating->stars = $input['stars'];
            $rating->notes = $input['notes'];
            $rating->save();

            return response()->json([
                'message' => 'Berhasil mengubah data rating dengan id ' . $rating->id . '',
                'data' => $rating,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rating = Rating::find($id);
            $rating->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete specified rating by id success.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 400);
        }
    }
}
