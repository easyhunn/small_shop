<?php

namespace App\Http\Controllers;

use App\Catagory;
use App\Comment;
use App\Product;
use App\Rating;
use Illuminate\Container\wrap;
use Illuminate\Contracts\Filesystem\move;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\getClientOriginalExtension;
use Auth;

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
        $this->authorize('create',Product::class);
        $catagories = Catagory::all();
        return view('product.create', compact('catagories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $this->validateData();
        $data['real_price'] = $data['price']*(100 - $data['percentage_discount'])/100;

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
    public function show(product $product, $slug)
    {
        //
        
        $catagories = Catagory::all();
        $rating = Rating::where('product_id', $product->id)->get();
        $comments = Comment::where('product_id', $product->id)->orderBy('id', 'DESC')->with('user','replies')->paginate(4);
        //$comments->setRelation('replies', $comments->replies()->paginate(2));

        return view('product.show', compact('product', 'catagories', 'rating', 'comments'));
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
        $catagories = Catagory::all();
        return view('product.edit', compact('product', 'catagories'));
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
        $this->authorize('update', $product);
        $data = request()->validate([
            'name'      =>  'required',
            'catagory_id'       =>  'required',
            'enable_display'    =>  'required',
            'description'        =>  'required',
            'stock'             =>  'required',
            'price'             =>   'required',
            'percentage_discount'  =>  'required|max:100|min:0',
            'image_source'      =>  'sometimes|file|image',
            'auxiliary_image_source'    =>  'sometimes|file|image', 
        ]);
        $data['real_price'] = $data['price']*(100 - $data['percentage_discount'])/100;
        $product->update($data);
        $this->storeImage($product);
        return redirect()->back();
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
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->back();
    }

    public function search() {
        $query = request()->data;
        $catagories = Catagory::all();
        $products = Product::where('name','like','%'.$query."%")->orderBy('id', 'DESC')->paginate(4);
        
        return view('home', compact('products', 'catagories'));
    }

    public function getAll() {
        $product = Product::all();
        return response()->json(
            $product->toArray(),
        );
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
    function validateData () {
        return request()->validate([
            'name'      =>  'required',
            'catagory_id'       =>  'required',
            'enable_display'    =>  'required',
            'description'        =>  'required',
            'stock'             =>  'required',
            'price'             =>   'required',
            'percentage_discount'  =>  'required|max:100|min:0',
            'image_source'      =>  'required|file|image',
            'auxiliary_image_source'    =>  'required|file|image', 
            
        ]);
    }
}
