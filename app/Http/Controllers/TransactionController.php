<?php

namespace App\Http\Controllers;

use App\Models\detailTransaksi;
use App\Models\transaction;
use App\Models\type_item;
use App\Models\item;
use App\Models\voucher;
use App\Models\subscription;
use App\Models\subscription_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transaction = transaction::all();

            if ($transaction->count() == 0) {
                return response()->json([
                    'message' => 'Data transaction tidak dtransactionukan',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Berhasil menampilkan data transaction',
                'data' => $transaction,
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
                'id_user' => 'required',
                'id_restaurant' => 'required',
                // 'id_voucher' => 'required',
                // 'address_on_trans' => 'required',
                // 'delivery_fee' => 'required',
                // 'order_fee' => 'required',
                // 'status' => 'required',
                // 'paymentMethod' => 'required',
                // 'datetime' => 'required',
            ]);
            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }
            //((delivery fee + order fee + subtotal - voucher) - ((delivery fee + order fee + subtotal - voucher) * subspercentage)

            $input['datetime'] = Carbon::now();

            $transaction = transaction::create($input);

            return response()->json([
                'message' => 'Berhasil menambahkan data transaction',
                'data' => $transaction,
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
            $transaksiUser = transaction::where('id_user', $iduser)->get();

            if (!$transaksiUser) {
                return response()->json([
                    'message' => 'Belum ada data transaksi untuk user ini',
                    'data' => [],
                ], 404);
            }

            if ($transaksiUser->isEmpty()) {
                return response()->json([
                    'message' => 'No transaction found for the specified user id.',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'message' => 'Successfully fetched transactions by user id.',
                'data' => $transaksiUser,
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
            $targetTransaction = transaction::find($id);

            $input = $request->all();
            $validate = Validator::make($input, [
                // 'id_voucher' => 'required',
                'address_on_trans' => 'required',
                'delivery_fee' => 'required',
                'order_fee' => 'required',
                'status' => 'required',
                'paymentMethod' => 'required',
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

            $details = detailTransaksi::where('id_transaksi', $id)->get();

            $transaction = collect();
            $input['subtotal'] = 0;
            foreach ($details as $detail) {
                $transaction = $transaction->merge($detail->transaction);
                $input['subtotal'] += $detail->item->price * $detail->quantity;
            }
            $subsdisc = 0;
            $search = subscription_user::where('user_id', $targetTransaction->id_user)->first();
            if ($search != null) {

                // $search = subscription_user::find($search->subscription_id);
                $here = subscription::find($search->subscription_id);
                $subsdisc = $here->percentage;
            } else {
                $subsdisc = 0;
            }

            $potonganVoucher = 0;
            $input['total'] = ($input['subtotal'] - ($input['subtotal'] * $subsdisc / 100));
            if ($targetTransaction->id_voucher != null) {
                $poucher = voucher::find($targetTransaction->id_voucher);
                $potonganVoucher = $poucher->cut_price;
                $input['total'] = $input['total'] - $potonganVoucher;
            }

            $input['datetime'] = Carbon::now();

            $targetTransaction->update($input);

            return response()->json([
                'message' => 'Berhasil mengedit data transaction',
                'data' => $targetTransaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function updateVoucher(Request $request, $id)
    {
        try {
            $targetTransaction = transaction::find($id);

            $input = $request->all();
            $validate = Validator::make($input, [
                'id_voucher' => 'required',
            ]);

            if ($validate->fails()) {
                return response(['message' => $validate->errors()], 400);
            }

            $targetTransaction->update($input);

            return response()->json([
                'message' => 'Berhasil mengedit data transaction update voucher',
                'data' => $targetTransaction,
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
    public function destroy(transaction $transaction)
    {
        //
    }
}
