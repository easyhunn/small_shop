<?php

namespace App\Http\Controllers;

use App\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function create () {
    	$data = request()->validate([
    		'comments' => 'required',
    		'product_id' => 'required',
    	]);

    	if(!Auth::check()) {
    		return redirect()->back();
    	}
    	Comment::create([
    		'user_id' => auth()->user()->id,
    		'product_id' => $data['product_id'],
    		'comments' 	=> $data['comments'],
    	]);
    	
    	return redirect()->back();
    }

    public function destroy (Comment $comment) {
    	$this->authorize('delete', $comment);
    	$comment->delete();
    	return response()->json([
    		'status' => 'success',
    	]);
    }

    public function update (Comment $comment) {

    	$data = request()->validate(['comments_update' => 'required',]);
    	
    	$comment->update([
    		'comments' => $data['comments_update'],
    	]);
    	return response()->json([
    		'status' => 'success'
    	]);
    }

    public function like (Comment $comment) {

    	$isLike = optional($comment->likes()->where('user_id', Auth::user()->id))->first();
    	$liked = 0; //status seft like

    	if (optional($isLike)->like) {
    		if($isLike->like === 1) {

    			$isLike->like = 0;
    			$isLike->save();   		
    			$liked = 0;			
    		} else {
    			$isLike->like = 1;
    			$isLike->save(); 
    		}
    	} else {
    		//0 know as null so use '0' instead 
    		if(optional($isLike)->like == '0') {
    			$isLike->like = 1;
    			$isLike->save(); 	
    		} else {
	    		$comment->likes()->create([
	    			'user_id' => Auth::user()->id,
	    			'comment_id' => $comment->id,
	    			'like' => '1',
	    		]);
    		}
    		$liked = 1;	
    	}

    	return response()->json([
		    'like' => $comment->likes()->where('like', 1)->count(),
		    'isLiked' => $liked,
		    'comments' => Comment::all()->toJson(),
		]);

    }
}
