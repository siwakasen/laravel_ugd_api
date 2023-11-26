<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $makanan = Makanan::all();

            if($makanan->count() == 0){
                return response()->json([
                    'message' => 'Data makanan tidak ditemukan',
                    'data' => [],
                ],404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data makanan',
                'data' => $makanan,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $input = $request->all();

            $validate = Validator::make($input,[
                'namaMakanan' => 'required',
                'hargaMakanan' => 'required',
                'namaFoto' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

           

            $makanan = Makanan::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data makanan',
                'data' => $makanan,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $makanan = Makanan::find($id);
            if(!$makanan){
                return response()->json([
                    'message' => 'Data makanan tidak ditemukan',
                    'data' => null,
                ],404);
            }
            return response()->json([
                'message' => 'Berhasil menampilkan data makanan',
                'data' => $makanan,
            ],200);
        }catch(\Exception $e){
                return response()->json([
                    'message' => $e->getMessage(),
                    'data' => [],
                ],400);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $input = $request->all();

            $validate = Validator::make($input,[
                'namaMakanan' => 'required',
                'hargaMakanan' => 'required',
                'namaFoto' => 'required'
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

           

            $makanan = Makanan::find($id);

            if(!$makanan){
                return response()->json([
                    'message' => 'Data makanan tidak ditemukan',
                    'data' => null,
                ],404);
            }

            $makanan->update($input);

            return response()->json([
                'message' => 'Berhasil mengubah data makanan',
                'data' => $makanan,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $makanan = Makanan::find($id);

            if(!$makanan){
                return response()->json([
                    'message' => 'Data makanan tidak ditemukan',
                    'data' => null,
                ],404);
            }
            $makanan->delete();

            return response()->json([
                'message' => 'Berhasil menghapus data makanan',
                'data' => $makanan,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ],400);
        }
    }
}
