<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //
    function show () {
    	$user = Auth::user();
    	return view('account.info', compact('user'));
    }
    
    function update() {
    	$data = request()->validate([
    		'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['sometimes', 'date'],
            'gender' => ['required', 'max:255'],
    	]);
    	Auth::user()->update($data);
    	return redirect()->back();
    }
    
    function changePassword () {
        return view('account.change-password');
    }

    function updatePassword() {
        $data = request()->validate([
            'oldPassword' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
       
        if(!Hash::check($data['oldPassword'], Auth::user()->password)) {
            return redirect()->back()->with('error', 'your old password not correct! try again');
        }

        Auth::user()->update([
            'password' => Hash::make($data['password'])
        ]);

        return redirect()->back()->with('success','update success');
    }
}
