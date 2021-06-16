<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        /**
         * The collapse method is gonna generate the unique list with several lists; unique collection with several collections inside
         */
       $categories =  $buyer->transactions()->with('product.categories')
       ->get()
       ->pluck('product.categories')
       ->collapse()
       ->unique('id')
       ->values();
       return $this->showAll($categories);
    }
}
