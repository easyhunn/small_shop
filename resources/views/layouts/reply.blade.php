<div class="card-header">
	{{ $reply->user->name }}
	<small class="text-muted">(<span class="font-italic">created at: </span>{{ $reply->created_at }})
	</small>
	<!--vote-->
	
</div>
<div class="card-body">
	{{ $reply->reply }}
</div>
<!--button-->
<div class="col-12">
	@can('delete', $reply)
	<div >
		<form action="{{ route('comment.destroy', compact('comment')) }}" method="post">
			@method('delete')
			@csrf
			<button class="float-right">Delete</button>
		</form>
	</div>
	@endcan
	@can('update', $reply)
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