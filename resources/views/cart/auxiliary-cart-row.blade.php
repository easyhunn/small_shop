<div id="aux_row{{ $auxiliaryCart->id }}">
	<div class="row pt-3 border-top">
		<div class="col-2">
			<img src="{{ asset('storage/'.$auxiliaryCart->product->image_source) }}" width="100">
		</div>
		<div class="col-8">
			<div class="row">
				<div class="col-9">
					<h5><a href="#">
						{{ $auxiliaryCart->product->product_name }}
					</a></h5>
				</div>
				
			</div>
			
			<div class="row mt-2">
				<div class="col-12 d-flex justify-content-start">
					<a href="javascript:void(0);" onclick="deleteFromAuxiliaryCart({{ $auxiliaryCart->id }})" class="border-left pl-3">Delete</a>
					<form action="" method="post">
						@csrf
						<input type="text" hidden name="productId" value="{{ $auxiliaryCart->product->id }}">
						<a onclick="this.closest('form').submit();return false;" href="#" class="border-left pl-3 ml-3">Add to cart</a>
					</form>
					
				</div>
			</div>
		</div>
		<div class="col-2 float-right">
			<strong>
			{{ $auxiliaryCart->product->real_price }}$
			</strong>
		</div>
	</div>
</div>


