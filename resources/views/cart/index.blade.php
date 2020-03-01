@extends('layouts.app')
@section('content')
<div class="p-4">
	<div class="row">
		<div class="col-9">
			@php
				$sum = 0;
				
			@endphp
			@foreach($carts as $cartKey => $cart)
				@php
					$sum += $cart->product->real_price*$cart->quantity;

				@endphp
				@include('cart.product-row')
			@endforeach
			
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-header" id="subTotal">
					SubTotal({{ $carts->sum('quantity') }}): {{ $sum }}
				</div>
				<div class="card-body d-flex justify-content-center">
					<button class="btn btn-dark">Proceeded to check out</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection