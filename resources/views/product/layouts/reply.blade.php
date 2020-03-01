
<div class="card mt-1" id="reply{{ $replyKey }}">
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
			<button class="float-right"onClick="deleteReply({{ $reply->id }},  {{ $replyKey }})">Delete</button>
		</div>
		@endcan
	</div>
</div>

<script>
	function deleteReply(reply, index) {
		
		try {
			
			$.ajax({
			url: '/reply/'+reply,
			type: 'delete',
			data: {
				"_token": "{{ csrf_token() }}",		
			}, 
			success: function(result) {
				let x = document.getElementById("reply"+index);
				x.parentNode.removeChild(x);
			},
			error: function(result) {
				alert(result.status);
			}
		});
		} catch (e) {
			document.write(e);
		}
	}
</script>