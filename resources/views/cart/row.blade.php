<div id="row{{ $cart->id }}">
	<div class="row pt-3 border-top">
		<div class="col-2">
			<img src="{{ asset('storage/'.$cart->product->image_source) }}" width="100">
		</div>
		<div class="col-8">
			<div class="row">
				<div class="col-9">
					<h5><a href="{{ $cart->product->public_path() }}">
						{{ $cart->product->name }}
					</a></h5>
				</div>
				
			</div>
			<div class="row mt-1">
				<div class="col-12 d-flex justify-content-start">
					<div class="mr-3">Quantity: </div>
					@if($cart->quantity < 10)
					<select name="quantities[quantity]" 
							id="quantity{{ $cart->product->id }}" 
							onchange="getMore({{ $cart->product->id }}, {{ $cart->id }})">
						<option value="{{ $cart->quantity }}" 
								selected>{{ $cart->quantity }}
						</option>
						@for($i = 1; $i < 10; ++$i)
						<option value="{{ $i }}">{{ $i }}</option>
						@endfor
						<option value="10" id="10+">10+</option>
					</select>
					@endif

					@if($cart->quantity >= 10) 
						<input type="number" value="{{ $cart->quantity }}"
								name="quantities[quantity]"
								id="bigQuantity{{ $cart->product->id }}" 
								style="width:50px;"
								oninput="show('update{{ $cart->product->id }}')">
						<button class="ml-1" 
								id="update{{ $cart->product->id }}" 
								onclick="updateBigQuantity({{ $cart->product->id }}, {{ $cart->id }})" hidden>
							update
						</button>					
					@else 
						<input type="number" 
								value="10" 
								name="quantities[quantity]" 
								id="bigQuantity{{ $cart->product->id }}" 
								style="width:50px;" 
								hidden disabled>
						<button class="ml-1" 
								hidden 
								id="update{{ $cart->product->id }}" 
								onclick="updateBigQuantity({{ $cart->product->id }}, {{ $cart->id }})">update
						</button>
					@endif
					
				</div>
			</div>
			<div class="row mt-2">
				@can('delete', $cart)
					<div class="col-12 d-flex justify-content-start">
						<a href="javascript:void(0);"
								onclick="deleteRow({{ $cart->id }})" 
								class="border-left pl-3">
							Delete
						</a>
						<form action="{{ route('cart.safe-for-late', compact('cart')) }}" method="post">
							@method('patch')
							@csrf
							<a onclick="this.closest('form').submit();return false;" href="#" class="border-left pl-3 ml-3">Save for later</a>
						</form>
						
					</div>
				@endcan
			</div>
		</div>
		<div class="col-2 float-right">
			<strong>
			{{ $cart->product->real_price }}$
			</strong>
		</div>
	</div>
</div>
