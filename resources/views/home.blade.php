@extends('layouts.app')

@section('content')

<div class="">
    <div class="row ">
        <div class="col-3">
            @include('layouts.lef-nav')
        </div>
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @include('layouts.main-index')
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
