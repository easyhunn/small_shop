@extends('layouts.app')
@section('content')
<script>
    function reloadSubTotal() { 
        //reload subtotal
        $.ajax({
            url: '/get-carts',
            type: 'get',
            data: {
                'status': '2',
            },
            success: function(carts) {
            //reload subtitle
                let subTotal = document.getElementById("subTotal");
                subTotal.innerHTML = "SubTotal(" + carts.quantity + "): " + carts.total + "$";

            },
            error:function (result) {
                    alert(result.status + ": " + result.responseJSON.message);
            }
        })  
    }
    
    function getMore(productId, cart) {
        
        updateQuantity(productId, cart);
        let select = document.getElementById("quantity"+productId);
        if(select.value != 10) {
            return;
        }

        select.setAttribute("hidden", "true");
        select.setAttribute("disabled", "true");
        let inputBox = document.getElementById("bigQuantity"+productId);
        inputBox.removeAttribute("hidden");
        inputBox.removeAttribute("disabled");
        let updateButton = document.getElementById("update"+productId);
        updateButton.removeAttribute("hidden");
    }

    function updateQuantity(productId, cart) {      
        let quantity = document.getElementById("quantity"+productId).value;
        try {
            
            $.ajax({
            url: '/cart/'+cart,
            type: 'patch',
            data: {
                _token: "{{ csrf_token() }}",
                'quantity': quantity,
                'productId': productId,
            },
            success:function (result) {
                //reload
                reloadSubTotal();
            },
            error:function (result) {
                alert(result.status + ": " + result.responseJSON.message);
            }
        });
        } catch (e) {
            document.write(e);
        }

    }
    function updateBigQuantity (productId, cart) {
        let quantity = document.getElementById("bigQuantity"+productId).value;
        try {
            
            $.ajax({
            url: '/cart/'+cart,
            type: 'patch',
            data: {
                _token: "{{ csrf_token() }}",
                'quantity': quantity,
                'productId': productId,
            },
            success:function (result) {
                //reload
                reloadSubTotal();
            },
            error:function (result) {
                alert(result.status + ": " + result.responseJSON.message);
            }
        });
        } catch (e) {
            document.write(e);
        }
    }
    function deleteRow (id) {
        $.ajax({
            url: '/cart/'+id,
            type: 'delete',
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (result) {
                //remove row
                let row = document.getElementById("row" + id);
                row.parentNode.removeChild(row);
                //reload subtitle
                reloadSubTotal();
            },
            error: function (result) {
                
                alert(result.status + " " + result.responseJSON.message);
            }
        });
    }

    function show (id) {
        document.getElementById(id).removeAttribute("hidden");
    }

    //auxiliary function
    function deleteFromAuxiliaryCart(auxiliaryCart) {

        $.ajax({
            url: "/auxilary-cart/" + auxiliaryCart,
            type: "delete",
            data: {
                _token:"{{ csrf_token() }}",
            },
            success:function(result) {
                let row = document.getElementById("aux_row" + auxiliaryCart);
                row.parentNode.removeChild(row);
                if(result.total != 0) {
                    auxiliaryTotal.innerHTML = "Safe for late(" + result.total +")";
                } else {
                    auxiliaryTotal.parentNode.remove(auxiliaryTotal);
                }
                
            }, 
            error:function(errors) {
                alert(errors.status+": "+errors.responseJSON.message);
            }
        });
        
    }

</script>
<div class="p-4">
    <div class="row">

        <div class="col-9">
    
            <!--row cart-->
            @php
                $sum = 0;
                
            @endphp
            @foreach($carts as $cartKey => $cart)
                @php
                    $sum += $cart->product->real_price*$cart->quantity;

                @endphp
                @include('process.productrow')
            @endforeach
            <!--row save_for_late-->
            
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header" id="subTotal">
                    SubTotal({{ $carts->sum('quantity') }}): {{ $sum }}$
                </div>
                <div class="card-body">
                    <address class="font-italic">
                        <ul>
                            <li>Name: {{ $user->name }}</li>
                            <li>Address: {{ $user->address }}</li>
                            <li>Phone: {{ $user->phone }}</li>
                            <li>Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                        </ul>
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

