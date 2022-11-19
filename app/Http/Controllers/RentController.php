<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Car;
use Carbon\Carbon;
use Auth;
use DB;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = Rent::all();

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
        $customer_id = Auth::id();
        $customer_name = Auth::user()->name;

        $car_id = $request->car_id;
        $car_model = Car::where('id', $car_id)->value('model');

        $rent_price = Car::where('id', $car_id)->value('rent_price');

        $rent_start = $request->rent_start;
        $rent_duration = $request->rent_duration;
        
        $rent_end = Carbon::create($rent_start);
        $rent_end = $rent_end->addDays($rent_duration);
        $rent_end->format('Y-m-d');

        $table = Rent::create([
            "customer_id" => $customer_id,
            "car_id" => $car_id,
            "customer_name" => $customer_name,
            "car_model" => $car_model,
            "rent_price" => $rent_price,
            "rent_duration" => $rent_duration,
            "rent_start" => $rent_start,
            "rent_end" => $rent_end,
        ]);

        return response()->json([
            "message"=>"Store Data Success!",
            "rent"=>$table
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
        $table = Rent::find($id);
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
        $table = Rent::find($id);
        if($table){
            $table->delete();

            return ["message"=>"Delete Data Success!"]; 
        }else{
            return ["message"=>"Data Not Found!"];
        }
    }
}
