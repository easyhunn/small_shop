<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>list order</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <a href="{{ route('home') }}" class="btn btn-link">Back</a>
    <div class="nav p-1 mb-3 d-flex justify-content-xl-center">
        <form action="{{ route('cart.all') }}" method="get" class="col-6">
            <input type="text" placeholder="Search by Name" name="name" class="form-control" list="customer">
            <datalist id="customer">
               
                @foreach($users as $user)
                    <option value="{{ $user->name }}">  
                @endforeach
            </datalist>
        </form>
    </div>

    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-3"><h4>Customer</h4></div>
                <div class="col-6"><h4>Product</h4></div>
                <div class="col-1"><h4>Status</h4></div>
        
            </div>
            @foreach($carts as $cart)
                <div class="row" id="row{{ $cart->id }}">
                    
                    @if($cart->status > 2)
                        <div class="col-3 text-muted">{{ $cart->user->name }}</div>
                        <div class="col-6 text-muted">{{ $cart->product->name }}</div>
                        <div class="col-2 text-muted" id="status{{ $cart->id }}">
                            finished
                        </div>
                        <div class="col-1">
                            <button id="finish{{ $cart->id }}" 
                                onclick="finish({{ $cart->id }})"
                                style="background-color:gray;">
                                finish
                            </button>
                        </div>
                    @else
                        <div class="col-3">
                            <a href="\process\{{ $cart->user->id }}">{{ $cart->user->name }}</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ $cart->product->public_path() }}">
                                {{ $cart->product->name }}
                            </a>
                        </div>
                        <div class="col-2 text-success" id="status{{ $cart->id }}">
                            on processing
                        </div>
                        <div class="col-1">
                            <button class="btn-info" id="finish{{ $cart->id }}" 
                                onclick="finish({{ $cart->id }})">
                                finish
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
            {{ $carts->links() }}
        </div>
    </div>
</body>

<script>
    function finish (cart) {
        try {
        $.ajax({
            url:"/cart/"+cart+"/finish",
            type:"patch",
            data:{
                _token:"{{ csrf_token() }}"
            },
            success:function (result) {

                let b = document.getElementById("finish"+cart);
                let r = document.getElementById("row"+cart);
                let s = document.getElementById("status"+cart);
                s.innerHTML = "finished";
                s.classList.remove = "text-success";
                r.style.color = "gray";
                b.style.backgroundColor = "gray";
                b.classList.remove("btn-info");
                btn.setAttribute("disabled", "true");
            },
            error:function (errors) {
                alert(errors.status + ": " + errors.responseJSON.message);
            }
        });
        } catch (e) {
            alert(e.stack );
        }
    }
</script>
</html>