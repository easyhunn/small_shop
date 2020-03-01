<div id="row{{ $cart->id }}">
	<div class="row pt-3 border-top">
		<div class="col-2">
			<img src="{{ asset('storage/'.$cart->product->image_source) }}" width="100">
		</div>
		<div class="col-8">
			<div class="row">
				<div class="col-9">
					<h5><a href="#">
						{{ $cart->product->product_name }}
					</a></h5>
				</div>
				
			</div>
			<div class="row mt-1">
				<div class="col-12 d-flex justify-content-start">
					<div class="mr-3">Quantity: </div>
					<select name="quantities[quantity]" id="quantity{{ $cartKey }}" onchange="getMore({{ $cartKey }}, {{ $cart->product->id }}, {{ $cart->id }})">
						<option value="{{ $cart->quantity }}" selected>{{ $cart->quantity }}</option>
						@for($i = 1; $i < 10; ++$i)
						<option value="{{ $i }}">{{ $i }}</option>
						@endfor
						<option value="10" id="10+">10+</option>
					</select>
					<input type="number" value="10" name="quantities[quantity]" id="moreQuantity{{ $cartKey }}" disabled hidden style="width:50px;">
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-12 d-flex justify-content-start">
					<a href="javascript:void(0);" onclick="deleteRow({{ $cart->id }})" class="border-left pl-3">Delete</a>
					<a href="#" class="border-left pl-3 ml-3">Save for later</a>
				</div>
			</div>
		</div>
		<div class="col-2 float-right">
			<strong>
			{{ $cart->product->real_price }}$
			</strong>
		</div>
	</div>
</div>
<script>
	function reloadSubTotal () {	
		//reload subtotal
		$.ajax({
			url: '/get-carts',
			type: 'get',
			success: function(carts) {
			//reload subtitle
				let subTotal = document.getElementById("subTotal");
				subTotal.innerHTML = "SubTotal(" + carts.quantity + "): " + carts.total + "$";
			},
			error:function (result) {
					alert(result.status + ": " + result.responseJSON.message);
			}
		})
		
		
	}
	function getMore(index, productId, cart) {
		let select = document.getElementById("quantity"+index);
		updateQuantity(productId, select.value, cart);
		if(select.value != 10) {
			return;
		}
		select.setAttribute("hidden", "true");
		select.setAttribute("disabled", "true");
		let inputBox = document.getElementById("moreQuantity"+index);
		inputBox.removeAttribute("hidden");
		inputBox.removeAttribute("disabled");
	}
	function updateQuantity(productId, quantity, cart) {
		try {
			
			$.ajax({
			url: '/cart/'+cart,
			type: 'patch',
			data: {
				_token: "{{ csrf_token() }}",
				'quantity': quantity,
				'productId': productId,
			},
			success:function (result) {
				//reload
				reloadSubTotal();
			},
			error:function (result) {
				alert(result.status + ": " + result.responseJSON.message);
			}
		});
		} catch (e) {
			document.write(e);
		}
	}
	function deleteRow (id) {
		$.ajax({
			url: '/cart/'+id,
			type: 'delete',
			data: {
				_token: "{{ csrf_token() }}",
			},
			success: function (result) {
				//remove row
				let row = document.getElementById("row" + id);
				row.parentNode.removeChild(row);
				//reload subtitle
				reloadSubTotal();
			},
			error: function (result) {
				alert(result.status + " " + result.responseJSON.message);
			}
		});
	}
</script>