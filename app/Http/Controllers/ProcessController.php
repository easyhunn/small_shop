<?php

namespace App\Http\Controllers;

use App\Process;
use App\Product;
use Auth;
use Illuminate\Http\Request;

class ProcessController extends Controller
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
        $user = Auth::user();

        $carts = $user->carts()->orderBy('id', 'DESC')->where('status', '2')->with('product')->get();
        
        return view('process.index', compact('carts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        return view('Process.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        Auth::user()->roles()->update(['status'=> 2]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process)
    {
        //
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        //
        $carts = Auth::user()->carts()->where('status', '1');
        foreach($carts->get() as $cart) {
            $product = Product::where('id', $cart->product_id);
            $product->update(['stock' => $product->first()->stock - $cart->quantity]);
        }
        $carts->update(['status'=> '2']);

        return redirect('/process');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        //
    }
}
