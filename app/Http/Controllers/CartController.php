<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $carts = Auth::user()->cart()->with('product')->get();
        return view('cart.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(!Auth::check()) {
            return response()->json([
                'message' => 'please login...'
            ]);
        }
        $data = $request->validate([
            'productId' => 'required',
            'quantity'  => 'required'
        ]);

        if($this->exist($data['productId'])) {
            
            $this->_update($data['productId'], $data['quantity']);
        } else {
            $this->_create($data['quantity'], $data['productId']);
        }   
        return response()->json([
            'message' => 'add to cart success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    private function _create (int $quantity,int $productId ) {
        Cart::Create([
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }
    private function _update(string $productId, string $quantity) {
        $oldQuantity = Auth::user()
                            ->cart()
                            ->where('product_id', $productId)
                            ->first()
                            ->quantity;
        
        Auth::user()
            ->cart()
            ->where('product_id', $productId)
            ->update(['quantity' => $oldQuantity + $quantity]);
    }
    private function exist(string $productId) {
        return !Cart::where('user_id', Auth::user()->id)
                        ->where('product_id', $productId)
                        ->get()
                        ->isEmpty();
    }
    
}
