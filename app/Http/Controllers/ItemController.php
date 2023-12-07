<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\type_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TypeItem;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        try {
            $item = item::all();

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
                'id_type' => 'required',
                'name' => 'required',
                'photo' => 'required',
                'price' => 'required',
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

            $item = item::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data type item',
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
     * Display the specified resource.
     */
    public function show($typeName)
    {
        try {
            $typeItems = type_item::where('name', $typeName)->get();

            if (!$typeItems) {
                return response()->json([
                    'message' => 'Type item not found.',
                    'data' => [],
                ], 404);
            }

            $items = collect();
            foreach ($typeItems as $typeItem) {
                $items = $items->merge($typeItem->items);
            }

            if ($items->isEmpty()) {
                return response()->json([
                    'message' => 'No items found for the specified type item name.',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Successfully fetched items by type item name.',
                'data' => $items,
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
    public function update(Request $request, item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(item $item)
    {
        //
    }
}
