<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Buyer;
// use App\User;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        // $buyers = User::all();

        // return response()->json(['data' => $buyers], 200);
        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    public function show(Buyer $buyer)
    {
        // $buyer = Buyer::has('transactions')->findorFail($id);

        // return response()->json(['data' => $buyer], 200);
        return $this->showOne($buyer);
    }
}
