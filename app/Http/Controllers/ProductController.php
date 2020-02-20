<?php

namespace App\Http\Controllers;

use App\Catagory;
use App\Product;
use App\Rating;
use Illuminate\Container\wrap;
use Illuminate\Contracts\Filesystem\move;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\getClientOriginalExtension;

class ProductController extends Controller
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
        $catagories = Catagory::all();
        return view('/product/create', compact('catagories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $request->validate([
            'product_name'      =>  'required',
            'catagory_id'       =>  'required',
            'enable_display'    =>  'required',
            'description'        =>  'required',
            'stock'             =>  'required',
            'price'             =>   'required',
            'percentage_discount'  =>  'required|max:100|min:0',
            'image_source'      =>  'required|file|image',
            'auxiliary_image_source'    =>  'required|file|image', 
            
        ]);

        $product = Product::create($data);
        $this->storeImage($product);
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
        $catagories = Catagory::all();
        $rating = Rating::where('product_id', $product->id)->get();
        
        return view('product.show', compact('product', 'catagories', 'rating'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }

    public function storeImage($product) {
        if(request()->hasFile('image_source')){
            $product->update([
                'image_source' => request()->image_source->store('uploads', 'public'),
                'auxiliary_image_source' => request()->auxiliary_image_source->store('uploads', 'public'),
            ]);
            $image = Image::make(public_path('storage/'.$product->image_source))->fit(640,830);
            $image->save();
            $auxiliary_image = Image::make(public_path('storage/'.$product->auxiliary_image_source))->fit(640,830);
            $auxiliary_image->save();
        }
    }
}
