@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/index.css') }}">
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
                        <div class="product-grid" style="height: 500px;">
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
                            @php
                            $avg = 0;
                            foreach ($rating as $rate) {
                            $avg += $rate->value;
                            }
                            if($rating->count() > 0)
                            $avg = ($avg/$rating->count());
                            @endphp
                        </div>
                    </div>
                    <div class="description col-6">
                        <div class="product-content">
                            <h3 class="title"><a href="#">{{ $product->name }}</a></h3>
                            
                            
                            <ul class="rating">
                                @if($avg == 0)
                                @for($i = 0; $i < 5; ++$i)
                                <li class="fa fa-star"></li>
                                @endfor
                                @else
                                @for($i = 0; $i < (int) $avg; ++$i)
                                <li class="fa fa-star"></li>
                                @endfor
                                @for($i = 0; $i < 5 - (int) $avg; ++$i)
                                <li class="fa fa-star disable"></li>
                                @endfor
                                @endif
                                
                                <span class="text-muted">({{ $avg }})</span>
                            </ul>
                            
                            @if(Auth::check())
                                @include('product.layouts.modal.vote')
                            @endif
                            
                            <div>
                                <small>
                                <a href="#" class="font-italic" data-toggle="modal" data-target="#voter">(there are {{ $rating->count() }} people rating this product)</a>
                                </small>
                                <!-- Button trigger modal -->
                                <!-- Modal -->
                                <div class="modal fade" id="voter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">All 
                                                {{ $rating->count() }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach($rating as $rate)
                                                <div>
                                                    <a href="#">{{ $rate->user->name }} ({{ $rate->value }})</a>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="price">
                                ${{ $product->real_price }}
                                <span><strike>${{ $product->price }}</strike></span>
                            </div>
                            <a class="add-to-cart" href="javascript:void(0)" data-toggle="modal" data-target="#quantity{{ $product->id }}">+ Add To Cart</a>
                            @include('layouts.add-to-cart-modal')
                            
                        </div>
                        @foreach(preg_split('/[\n]/', $product->description) as $detail)
                        @if(strlen($detail) > 1)
                        <li>{{ $detail }}</li>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 container mt-5">
                @include('product.layouts.comment')
            </div>
        </div>
        
    </div>
</div>
@endsection