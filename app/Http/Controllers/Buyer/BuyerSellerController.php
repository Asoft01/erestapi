<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // $sellers = $buyer->transactions()->with('product.seller')
        // ->get();


        /**
         * This is used to pluck the sellers belonging to a product 
         * 
         */ 
        // $sellers = $buyer->transactions()->with('product.seller')
        // ->get()
        // ->pluck('product.seller');

        /**
         * This is used to take unique sellers only but the unique id might return sellers that has an empty values hence you can use the below
         * 
         */

        // $sellers = $buyer->transactions()->with('product.seller')
        // ->get()
        // ->pluck('product.seller')
        // ->unique('id');

        /**
         * This is used to take only transactions that uniques with their respective values, hence returning the exact corresponding values 
         * just like the second style
         * 
         */
        
         
        $sellers = $buyer->transactions()->with('product.seller')
        ->get()
        ->pluck('product.seller')
        ->unique('id')
        ->values();
        
        return $this->showAll($sellers);
    }
}
