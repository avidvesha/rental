<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Rent;
use Carbon\Carbon;
use DB;
use Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = Payment::all();

        return response()->json([
            'message' => 'Load Data Success!',
            'data' => $table
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $customer_id = Auth::id();
        // $customer_name = Auth::user()->name;

        $rent_id = $request->rent_id;

        $customer_id = Rent::where('id', $rent_id)->value('customer_id');
        $customer_name = Rent::where('id', $rent_id)->value('customer_name');
        $price = Rent::where('id', $rent_id)->value('rent_price');
        // $price = Rent::sum(DB::raw('rent_duration * rent_price'));

        $payment_date = Carbon::now();

        $table = Payment::create([
            "rent_id" => $rent_id,
            "customer_id" => $customer_id,
            "customer_name" => $customer_name,
            "price" => $price,
            "payment_date" => $payment_date,
        ]);

        return response()->json([
            "message"=>"Store Data Success!",
            "payment"=>$table
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = Payment::find($id);
        if($table){
            return $table;
        }else{
            return ["message" => "Data Not Found!"];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Payment::find($id);
        if($table){
            $table->delete();

            return ["message"=>"Delete Data Success!"]; 
        }else{
            return ["message"=>"Data Not Found!"];
        }
    }
}
