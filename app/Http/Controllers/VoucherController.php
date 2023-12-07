<?php

namespace App\Http\Controllers;

use App\Models\voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $voucher = voucher::all();

            if ($voucher->count() == 0) {
                return response()->json([
                    'message' => 'Data voucher tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data voucher',
                'data' => $voucher,
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
                'name' => 'required',
                'cut_price' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }
            $voucher = voucher::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data type_$voucher',
                'data' => $voucher,
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
    public function show($string)
    {
        try {
            $voucher = voucher::find($string);
            if (!$voucher) {
                return response()->json([
                    'message' => 'Data voucher tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data voucher dengan id ' . $voucher->id_transaksi . '',
                'data' => $voucher,
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
            $voucher = voucher::find($id);

            if (!$voucher) {
                return redirect()->route('buku.index')->with(['error' => 'Record not found']);
            }

            //validate form 
            $this->validate($request, [
                'name' => 'required',
                'cut_price' => 'required',


            ]);

            $voucher->update([
                'name' => $request->name,
                'cut_price' => $request->cut_price,


            ]);

            return response()->json([
                'message' => 'Berhasil mengupdate data voucher',
                'data' => $voucher,
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
            $voucher = voucher::find($id);
            $voucher->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete specified voucher by id success.',
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
