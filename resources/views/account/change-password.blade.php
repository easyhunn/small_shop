@extends('layouts.app')

@section('content')

<div class="">
    <div class="row ">
        <div class="col-3">
        </div>
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if(session('success'))
                        <small class="alert alert-success" >{{ session('success') }}</small>
                    @endif
                    <form action="{{ route('account.update-password') }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="oldPassword">Old password</label>
                            <input type="password" name="oldPassword" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input type="password" value="{{ old('newPassword') }}" name="password" class="form-control">
                            @error('password')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Rewrite password</label>
                            <input type="password" value="{{ old('rewritePassword') }}" name="password_confirmation" class="form-control">
                        </div>
                        <div>
                            @if(session('error'))
                                <small class="text-danger">{{ session('error') }}</small>
                            @endif
                            
                        </div>
                        
                        <button class=" btn btn-warning">Update</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

