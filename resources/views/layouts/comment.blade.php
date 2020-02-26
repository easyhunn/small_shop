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
			<span id="changed{{ $key }}"></span>
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
		<div class="card-body" id="cardBody{{ $key }}" }}>
			
			@foreach(preg_split('/[\n]/',$comment->comments) as $line)
			<div>{{ $line }}</div>
			@endforeach
		</div>
		<!--button group-->
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
				<button type="button" class=" float-right" onclick="showHide('editBox{{ $key }}', 'update_button{{ $key }}')" name = "update_button" id="update_button{{ $key }}">edit</button>
				
			</div>
			@endcan
			@if(Auth::check())
			<button type="button" class=" float-right" onclick="showHide('reply_box{{ $key }}','reply_button{{ $key }}')" name = "reply_button" id="reply_button{{ $key }}">reply</button>
			@endif
			<div class="">
				<button class="border-0 col-sm-2" onclick="like({{ $comment->id }}, {{ $key }})" >
					@if(!$comment->liked())
					<i  class="fa fa-thumbs-up" name="like_contain" style="font-size: 20px;" aria-hidden="true"> 
						like {{ $comment->likes()->where('like',1)->count() }}
					</i>
					@else
					<i  class="fa fa-thumbs-up" name="like_contain" style="font-size: 20px; color: #3399FF;" aria-hidden="true"> 
						like {{ $comment->likes()->where('like',1)->count() }}
					</i>
					@endif
				</button>	
				
			</div>
		</div>
		
		<!--end button group-->
		<div name="editBox" hidden="true" id = "editBox{{ $key }}">
			
			
			<input type="text" id="commentUpdate{{ $key }}" style="width:300px;">
			<button id="saveChange{{ $key }}" onclick = "editFunction({{ $comment->id }}, {{ $key }});">change</button>
			<a href="javascript:void(0);" onclick="showHide('update_button{{ $key }}', 'editBox{{ $key }}')">Cancel</a>			
			
			
		</div>
		
	</div>
	<div class="mt-1">
		<!--input box for replies-->
		<form action="{{ route('reply.store', compact('comment')) }}" method="post">
			@csrf
			
			<input type="text" name="reply_box" id="reply_box{{ $key }}" hidden class="form-control" placeholder="write your replies...">
		</form>
	</div>
	@if($comment->replies()->count() > 0)
	<a href="javascript:void(0);" onclick="showHide('replies{{ $key }}','viewMoreReplies{{ $key }}')" name="viewMoreReplies" id="viewMoreReplies{{ $key }}">view more {{ $comment->replies()->count() }} reply</a>
	@else
	<a href="javascript:void(0);" hidden name="viewMoreReplies">view more {{ $comment->replies()->count() }} reply</a>
	@endif

	<div class="container ml-5 small col-11 mt-3" name="replies" id="replies{{ $key }}" hidden>
		<!--paginate -->
		
		@foreach($comment->replies()->get() as $replyKey => $reply)
		@include('layouts.reply')
		
		@endforeach
		<a href="javascript:void(0);" onclick="showHide('viewMoreReplies{{ $key }}','replies{{ $key }}')" >View less</a>
	</div>

	
	@endforeach
	<div class="col-12 mt-3">{{ $comments->links() }}</div>
</div>
<script>

	function showHide (showId, hideId) {
		let showElement = document.getElementById(showId);
		let hideElement = document.getElementById(hideId);
		showElement.removeAttribute("hidden");
		hideElement.setAttribute("hidden","true");
	}

	//like request
	function like (comment, index) {
		$.ajax({
            url: '/Comment/'+comment+'/like',
            type: 'POST',
            data: {
            	"_token": "{{ csrf_token() }}"
        	},
            success: function (result) {
            	let like = document.getElementsByName("like_contain")[index];
            	like.innerHTML = " like " + result.like;
            	if(result.isLiked == 1) {
            		like.style.color = "#3399FF";
            	} else {
            		like.style.color = "black";
            	}

            },
            error: function(xhr, status, error) {
			  	alert("please login to likes");
			}
        });
	}
	function editFunction(comment, index) {
		let comments_update = document.getElementById("commentUpdate"+index).value;
		$.ajax({
			url: '/Comment/' + comment,
			type: 'patch',
			data: {
				"_token": "{{ csrf_token() }}",
				"comments_update": comments_update, 
			},
			success: function(result) {
				document.getElementById("cardBody"+index).innerHTML = comments_update;
				
			},
			error: function (result) {
				alert("error" + result.status);
			}

		});
		
	}
</script>