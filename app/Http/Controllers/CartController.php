<?php

namespace App\Http\Controllers;

use App\AuxiliaryCart;
use App\Cart;
use App\Product;
use App\User;
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
        $carts = Auth::user()->carts()->orderBy('id', 'DESC')->where('status', '1')->with('product')->get();
        $auxiliaryCarts = Auth::user()->carts()->orderBy('id', 'DESC')->where('status', '0')->with('product')->get();
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
            'quantity'  => 'required',
        ]);
        $data['status'] = 1;
        
        //check avaiable quantity
        $available = Product::where('id', $data['productId'])->first()->stock;
        if($data['quantity'] > $available) 
            return response()->json([
                'message' => 'not enough product available: '.$available
            ]);

        //case update
        $status = Auth::user()
                        ->carts()
                        ->where('product_id', $data['productId'])
                        ->orderBy('updated_at', 'DESC')
                        ->first()
                        ->status;
        
        if($this->exist($data['productId']) && $status <= 2) {
            $cart = Auth::user()
                            ->carts()
                            ->where('product_id', $data['productId'])
                            ->first();
            $quantity = $data['quantity'] + $cart->quantity;
            $this->_update($data['productId'], $quantity);
            $data['quantity'] = $quantity;
            $this->resetStock($cart, $data);
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
        
        //up date stock
        $this->resetStock($cart, $data);
        
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
        $this->authorize('delete', $cart);
        if($cart->status == 2) {
            $product = Product::where('id', $cart->product_id);
            $product->update(['stock' => $product->first()->stock + $cart->quantity]);  
        }
        $cart->delete();
    }

    private function _create (int $quantity,int $productId ) {
        Cart::Create([
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'status'   => 1,
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
         $carts = Auth::user()->carts()->where('status', request()->status)->with('product')->get();
         $sum = 0;
         foreach($carts as $cart) {
            $sum += $cart->product->real_price * $cart->quantity;
         }

         return response()->Json([
            'quantity' => $carts->sum('quantity'),
            'total' => round($sum, 2),
         ]);
    }

    function addToCart (Request $request, Cart $cart) {
        //from safe for late to cart
        $cart->update(['status' => '1']);
        return redirect()->back();
    }

    function safeForLate (Cart $cart) {
        //from cart to safe for late
        $cart->update(['status' => '0']);
        return redirect()->back();
    }

    function resetStock (Cart $cart, $data) {
        $cartQuantity = $data['quantity'] - $cart->quantity;
        $product = Product::where('id', $cart->product_id);
        $productQuantity = $product->first()->stock;
        $quantity = $productQuantity - $cartQuantity;
        if($quantity < 0) {
            //request more than stock avaiable
            return response()->json([
                'message' => 'not enough available product. available: '. $productQuantity
            ]);
        }
        if($cart->status == 2)
            //on processing
            $product->update(['stock' => $quantity]);
    }
    function all () {
        $this->authorize('viewAny', Cart::class);
        $users = User::all();
        $carts = Cart::where('status','>=', '2')
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'like', '%'.(request()->name ?? '').'%');
                    })
                    ->orderBy('updated_at','DESC')
                    ->paginate(20);
       
        return view('list.order', compact('carts', 'users')); 
    }
    function finish (Cart $cart) {
        $cart->update(['status' => '3']);
    }

}
