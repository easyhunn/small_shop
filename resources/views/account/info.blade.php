@extends('layouts.app')

@section('content')

<div class="">
    <div class="row ">
        <div class="col-2">
           <!--left bar-->

        </div>
        <div class="col-md-8">
            <!--center view-->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('account.update') }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="number" name="phone" class="form-control" value="{{ $user->phone }}">
                            
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="enail" name="email" disabled class="form-control" value="{{ $user->email }}">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-warning">Update</button> 
                        <a href="{{ route('account.change-password') }}" class="float-right">Change password</a>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        @endif   
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

