<small class="font-italic">(<a href="#">there are {{ $comments->total() }} reply for this product</a>)</small>
<form action="{{ route('comment.create') }}" method="get">
	
	<textarea placeholder="write your comments..." name="comments" id="comments" cols="30" rows="5" class="form-control">

	</textarea>
	@error('comments')
		<small class="text-danger">{{ $message }}</small>
	@enderror
	<input type="hidden" name="product_id" value="{{ $product->id }}">
	
	@if(Auth::check())
	<button type="submit" class="btn btn-info mt-1">Share</button>
	@else
	<small><a href="{{ route('login') }}" class="text-danger">please login to comments...</a></small> 
	@endif
	@if($errors->any())
		@foreach($errors->all() as $error)
			{{ $error }}
		@endforeach
	@endif
</form>
<div class="container mt-5">
	
	@foreach($comments as $comment)
		<div class="col-12 card mt-3">
			<div class="card-header">
				{{ $comment->user->name }}
				<small class="text-muted">(<span class="font-italic">created at: </span>{{ $comment->created_at }})</small>
			</div>
			<div class="card-body">
				
				@foreach(preg_split('/[\n]/',$comment->comments) as $line)
					<div>{{ $line }}</div>
				@endforeach
			</div>
			@can('delete', $comment)
			<div class="col-12">
				<form action="{{ route('comment.destroy', compact('comment')) }}" method="post">
					@method('delete')
					@csrf
					<button class="btn-sm btn-outline-danger float-right">Delete</button>
				</form>
			</div>
			@endcan
		</div> 
		
	@endforeach
	<div class="col-12 mt-3">{{ $comments->links() }}</div>
</div>