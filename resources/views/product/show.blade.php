@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/index.css') }}">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<div class="">
    <div class="row ">
        <div class="col-3">
            @include('layouts.lef-nav')
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="col-md-6">
                        <div class="product-grid">
                            <div class="product-image">
                                <img class="pic-1" src="{{ asset('storage/'.$product->image_source) }}">
                                <img class="pic-2" src="{{ asset('storage/'.$product->auxiliary_image_source) }}">
                                <ul class="social">
                                    <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                                    <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                                <span class="product-new-label">Sale</span>
                                <span class="product-discount-label">{{ $product->percentage_discount }}%</span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="description col-6">
                        <div class="product-content">
                            <h3 class="title"><a href="#">{{ $product->product_name }}</a></h3>
                            <ul class="rating">
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star disable"></li>
                            </ul>
                            <div class="price">
                                ${{ (int)(($product->price)*(100 - $product->percentage_discount)/100) }}
                                <span><strike>${{ $product->price }}</strike></span>
                            </div>
                            <a class="add-to-cart" href="">+ Add To Cart</a>
                            
                        </div>
                        @foreach(preg_split('/[\n]/', $product->description) as $detail)
                        @if(strlen($detail) > 1)
                            <li>{{ $detail }}</li>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection