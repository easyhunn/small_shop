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
                            <label for="address">Address:</label>
                            <input type="text" name="address" class="form-control" value="{{ $user->address }}">

                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <button class="">Update</button> 
                        <button type="button" class="btn-warning" onclick="continues()">continue</button>
                        <!--any error-->
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        @endif   
                    </form>
                    
                    <form action="{{ route('process.update') }}" method="post" id="continueProcess">
                        @method('patch')
                        @csrf
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function continues() {
        document.getElementById('continueProcess').submit();
    }
</script>
@endsection

