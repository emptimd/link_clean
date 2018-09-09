<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index($product)
    {

        return view('products.index', ['product' => $product]);
    }

    public function views(Request $request)
    {

        return view('products._'.$request->view)->render();
    }
}