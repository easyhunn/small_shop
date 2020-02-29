<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Product;
use App\Rating;
use Auth;
use Illuminate\Http\Request;

class RatingController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $data = $request->validate([
            'rating' => 'required|max:5|min:1',
            'comments' => 'sometimes',
        ]);

        $this->requiedLogin();
      
        if ($this->Exist($product->id)) {
            $this->_update($request->rating, $product->id);
        } else {
            $this->_create($request->rating, $product->id);  
        }   
        $this->_createComment($request->comments, $product->id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }

    private function requiedLogin () {
        if(!Auth::check()) {
            return redirect()->back()->with('status','please login before rating');
        }
    }

    private function Exist ($productId) {
        return !Rating::where('user_id', Auth::user()->id)
                    ->where ('product_id', $productId)
                    ->get()->isEmpty();
    }

    private function _update ($value, $productId) {
        Rating::where('user_id', Auth::user()->id)
                    ->where ('product_id', $productId)
                    ->update(['value' => $value]);
    }
    private function _create ($value, $productId) {
        Rating::create([
                'user_id' => Auth::user()->id,
                'product_id'=> $productId,
                'value' => $value,
            ]);
    }
    private function _createComment($value, $productId) {
        if ($value == null) 
            return;
        Comment::create([
                'user_id' => Auth::user()->id,
                'product_id'=> $productId,
                'comments' => $value,
            ]);
    }
}
