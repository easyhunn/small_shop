<?php

namespace App\Http\Controllers;

use App\AuxiliaryCart;
use App\Cart;
use Auth;
use Illuminate\Http\Request;

class AuxiliaryCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->deleteCart($data['productId']);

        if(!$this->exist($data['productId'])) {
            $this->_create($request->productId, $request->quantity);
        } else {
            $quantity = AuxiliaryCart::where('user_id', Auth::user()->id)
                                        ->where('product_id', $data['productId'])
                                        ->first()->quantity + $data['quantity'];
            $this->_update($request->productId, $quantity);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AuxiliaryCart  $auxiliaryCart
     * @return \Illuminate\Http\Response
     */
    public function show(AuxiliaryCart $auxiliaryCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuxiliaryCart  $auxiliaryCart
     * @return \Illuminate\Http\Response
     */
    public function edit(AuxiliaryCart $auxiliaryCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuxiliaryCart  $auxiliaryCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuxiliaryCart $auxiliaryCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuxiliaryCart  $auxiliaryCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuxiliaryCart $auxiliaryCart)
    {
        //

        $auxiliaryCart->delete();
        $total = AuxiliaryCart::all()->count();
        return response()->json([
            'total' => $total
        ]);
    }
    private function _create ($productId, $quantity) {
        AuxiliaryCart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }
    private function _update(string $productId, $quantity) {      
        Auth::user()
            ->auxiliaryCarts()
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);
    }
    private function exist(string $productId) {
        return !AuxiliaryCart::where('user_id', Auth::user()->id)
                        ->where('product_id', $productId)
                        ->get()
                        ->isEmpty();
    }
    private function deleteCart($productId) {
        Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $productId)
                ->delete();
    }
}
