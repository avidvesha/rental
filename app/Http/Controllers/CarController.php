<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = Car::all();

        return response()->json([
            'message' => 'Load Data Car Success!',
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
        $table = Car::create([
            "model" => $request->model,
            "seat" => $request->seat,
            "transmition" => $request->transmition,
            "color" => $request->color,
            "rent_price" => $request->rent_price,
            "number" => $request->number,
            "release_date" => $request->release_date
        ]);

        return response()->json([
            "message"=>"Store Data Car Success!",
            "car"=>$table
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
        $table = Car::find($id);
        if($table){
            return $table;
        }else{
            return ["message" => "Data Car Not Found!"];
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
        $table = Car::find($id);
        if($table){
            $table->model = $request->model ? $request->model : $table->model;
            $table->seat = $request->seat ? $request->seat : $table->seat;
            $table->transmition = $request->transmition ? $request->transmition : $table->transmition;
            $table->color = $request->color ? $request->color : $table->color;
            $table->rent_price = $request->rent_price ? $request->rent_price : $table->rent_price;
            $table->number = $request->number ? $request->number : $table->number;
            $table->release_date = $request->release_date ? $request->release_date : $table->release_date;
            $table->save();

            return $table;
        }else{
            return ["message"=>"Data Car Not Found!"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Car::find($id);
        if($table){
            $table->delete();

            return ["message"=>"Delete Car Success!"]; 
        }else{
            return ["message"=>"Data Car Not Found!"];
        }
    }
}
