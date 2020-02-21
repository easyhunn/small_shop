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
    	return redirect()->back();
    }
}
