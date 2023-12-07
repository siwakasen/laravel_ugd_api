<?php

namespace App\Http\Controllers;

use App\Models\subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subscription = Subscription::all();

            if ($subscription->count() == 0) {
                return response()->json([
                    'message' => 'Data subscription tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data subscription',
                'data' => $subscription,
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
                'price' => 'required',
                'percentage' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }


            $subscription = Subscription::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data subscription',
                'data' => $subscription,
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
    public function show(subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {

        try {


            if (!$subscription) {
                return redirect()->route('buku.index')->with(['error' => 'Record not found']);
            }

            //validate form 
            $this->validate($request, [
                'name' => 'required',
                'price' => 'required',
                'percentage' => 'required',
            ]);

            $subscription->update([
                'name' => $request->name,
                'price' => $request->price,
                'percentage' => $request->percentage,
            ]);

            return response()->json([
                'message' => 'Berhasil update data rating',
                'data' => $subscription,
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
    public function destroy(Subscription $subscription)
    {
        try {
            // $subscription = Subscription::find($subscription->id);
            $subscription->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete specified subscription success.',
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
