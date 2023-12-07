<?php

namespace App\Http\Controllers;

use App\Models\type_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $item = type_item::all();

            if ($item->count() == 0) {
                return response()->json([
                    'message' => 'Data item tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data item',
                'data' => $item,
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
                'size' => 'required',
                'customize' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }
            $type_item = type_item::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data type_$type_item',
                'data' => $type_item,
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
    public function show(type_item $type_item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, type_item $type_item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(type_item $type_item)
    {
        //
    }
}
