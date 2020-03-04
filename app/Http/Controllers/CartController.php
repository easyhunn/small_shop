<?php

namespace App\Http\Controllers;

use App\AuxiliaryCart;
use App\Cart;
use Auth;
use Illuminate\Http\Request;

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
        $carts = Auth::user()->carts()->orderBy('id', 'DESC')->with('product')->get();
        $auxiliaryCarts = Auth::user()->AuxiliaryCarts()->orderBy('id', 'DESC')->with('product')->get();

        return view('cart.index', compact('carts', 'auxiliaryCarts'));
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
            $oldQuantity = Auth::user()
                            ->carts()
                            ->where('product_id', $data['productId'])
                            ->first()
                            ->quantity;

            $quantity = $data['quantity'] + $oldQuantity;
            $this->_update($data['productId'], $quantity);
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
        $data = $request->validate([
            'quantity' => 'required|min:0',
            'productId' => 'required',
        ]);
        $this->_update($data['productId'], $data['quantity']);

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
        $cart->delete();
    }

    private function _create (int $quantity,int $productId ) {
        Cart::Create([
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }
    private function _update(string $productId, $quantity) {      
        Auth::user()
            ->carts()
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);
    }
    private function exist(string $productId) {
        return !Cart::where('user_id', Auth::user()->id)
                        ->where('product_id', $productId)
                        ->get()
                        ->isEmpty();
    }
    function getCarts () {
        //get quantity and total product
         $carts = Auth::user()->carts()->with('product')->get();
         $sum = 0;
         foreach($carts as $cart) {
            $sum += $cart->product->real_price * $cart->quantity;
         }

         return response()->Json([
            'quantity' => $carts->sum('quantity'),
            'total' => round($sum, 2),
         ]);
    }

    function addToCart (Request $request) {

        $this->store($request);
        $this->destroyAuxiliaryCart($request->auxiliaryCart);
        return redirect()->back();
    }

    //auxiliary function
    function destroyAuxiliaryCart ($auxiliaryCart) {
        AuxiliaryCart::where('id', $auxiliaryCart)->delete();
    }
}
