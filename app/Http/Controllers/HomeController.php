<?php

namespace App\Http\Controllers;

use App\Catagory;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\reverse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $catagories = Catagory::all();
        $products = Product::where('enable_display',1)->orderBy('id', 'DESC')->paginate(4);
        return view('home', compact('products', 'catagories'));
    }
}
