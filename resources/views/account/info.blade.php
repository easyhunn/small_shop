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
                            <input type="email" name="email" disabled class="form-control" value="{{ $user->email }}">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" name="address" class="form-control" value="{{ $user->address }}">

                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="date_of_birth">Date of birth</label>
                            <input type="text" name="date_of_birth" class="form-control" value="{{ $user->date_of_birth }}">

                            @error('date_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">gender</label>
                            <select name="gender" class="custom-select" id="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-warning">Update</button> 
                        <a href="{{ route('account.password') }}" class="float-right">Change password</a>
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

