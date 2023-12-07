<?php

namespace App\Http\Controllers;

use App\Models\detailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = detailTransaksi::all();

            if ($data->count() == 0) {
                return response()->json([
                    'message' => 'Data detailTransaksi tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data detailTransaksi',
                'data' => $data,
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
                'id_item' => 'required',
                'quantity' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }


            $data = detailTransaksi::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data rating',
                'data' => $data,
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
    public function show(detailTransaksi $detailTransaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, detailTransaksi $detailTransaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(detailTransaksi $detailTransaksi)
    {
        //
    }
}
