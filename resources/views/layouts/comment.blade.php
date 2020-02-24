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
	
	@foreach($comments as $key => $comment)
		<div class="col-12 card mt-3">
			<div class="card-header">
				{{ $comment->user->name }}
				<small class="text-muted">(<span class="font-italic">created at: </span>{{ $comment->created_at }})
				</small>
				<!--vote-->
				@if($comment->getVote() > 0)
					<div>
						<ul class="rating">
							@for($i = 0; $i < $comment->getVote(); ++$i)
								<li class="fa fa-star"></li>
							@endfor
							@for($i = 0; $i < 5 - $comment->getVote(); ++$i)
								<li class="fa fa-star disable"></li>
							@endfor
						</ul>
					</div>
				@endif
			</div>
			<div class="card-body">
				
				@foreach(preg_split('/[\n]/',$comment->comments) as $line)
					<div>{{ $line }}</div>
				@endforeach
			</div>
			<!--button-->
			<div class="col-12">
				@can('delete', $comment)
				<div >
					<form action="{{ route('comment.destroy', compact('comment')) }}" method="post">
						@method('delete')
						@csrf
						<button class="float-right">Delete</button>
					</form>
				</div>
				@endcan
				@can('update', $comment)
				<div class="">

					<form action="{{ route('comment.update', compact('comment')) }}" method="post">
						@method('patch')
						@csrf
						
						<button type="button" class=" float-right" onclick="showCommentsUpdateInput({{ $key }})" name = "update_button">edit</button>
						<input type="text" name="comments_update[]" hidden class="form-control">
					</form>

				</div>
				@endcan
			</div>

		</div> 
		
	@endforeach
	<div class="col-12 mt-3">{{ $comments->links() }}</div>
</div>

<script>

	
	function showCommentsUpdateInput (index) {
		let commentsUpdateInput = document.getElementsByName("comments_update[]")[index];
		let update_button = document.getElementsByName("update_button")[index];
		commentsUpdateInput.removeAttribute("hidden");
		update_button.setAttribute("hidden","true");
	}
</script>