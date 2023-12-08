<?php

namespace App\Http\Controllers;

use App\Models\subscription_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SubscriptionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subscription = subscription_user::all();

            if ($subscription->count() == 0) {
                return response()->json([
                    'message' => 'Data subscription tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data subscription_user',
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
                'user_id' => 'required',
                'subscription_id' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

            $input['start_date'] = Carbon::now();
            $input['end_date'] = Carbon::now()->addMonth();
            $subscriptionuser = subscription_user::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data subscription user',
                'data' => $subscriptionuser,
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
    public function show($id)
    {
        try {
            $subscription = subscription_user::where('user_id', $id)->first();
            
            if (!$subscription) {
                return response()->json([
                    'message' => 'Data subscription tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data subscription_user',
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            

            $validate = Validator::make($input, [
                'subscription_id' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }
            $subscription = subscription_user::where('user_id', $id)->first();

            if (!$subscription) {
                return response()->json([
                    'message' => 'Data subscription tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            $subscription->update($input);

            return response()->json([
                'message' => 'Berhasil mengubah data subscription',
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
    public function destroy($id)
    {
        try {
            $subs = subscription_user::where('user_id', $id)->first();
            
            if (!$subs) {
                return response()->json([
                    'message' => 'Data subs tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            $subs->delete();

            return response()->json([
                'message' => 'Berhasil menghapus data subs',
                'data' => $subs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}
