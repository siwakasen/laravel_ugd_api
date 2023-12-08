<?php

namespace App\Http\Controllers;

use App\Models\restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $restoran = Restaurant::all();

            if ($restoran->count() == 0) {
                return response()->json([
                    'message' => 'Data restoran tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data restoran',
                'data' => $restoran,
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
                'address' => 'required',
                'postalCode' => 'required',
                'city' => 'required',
                'openingHours' => 'required',
                'closedHours' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }


            $restoran = Restaurant::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data restoran',
                'data' => $restoran,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
    public function show($id)
    {
        try {
            $restoran = Restaurant::find($id);

            if ($restoran->count() == 0) {
                return response()->json([
                    'message' => 'Data restoran tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data restoran',
                'data' => $restoran,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}
