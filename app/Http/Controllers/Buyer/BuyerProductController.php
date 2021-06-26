<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
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
        // $products = $buyer->transactions->product;
        /**
         * The pluck method is used to pull only the single products associated to the transactions only instead of writing
         * $products = $buyer->transactions()->with('product')->get();
         */
        $products = $buyer->transactions()->with('product')
        ->get()
        ->pluck('product');
        return $this->showAll($products);
    }
}
