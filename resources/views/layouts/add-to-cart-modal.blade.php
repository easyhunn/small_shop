<!-- Modal -->

<div class="modal fade" id="quantity{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <input type="number" id="quantityBox{{ $product->id }}" name="quantity" value="1">
                <input type="text" name="productId" id="productId{{ $product->id }}" hidden value="{{ $product->id }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
                <button type="submit" onclick="addToCart({{ $product->id }})" class="btn btn-primary">ADD</button>
                
            </div>
            
        </div>
    </div>
</div>

<script>
    function addToCart(index) {

        let quantity = document.getElementById("quantityBox"+index).value;
       
        let productId = document.getElementById("productId"+index).value;
        $.ajax({
            url:'/cart',
            type:'post',
            data:{
                _token: "{{ csrf_token() }}",
                'quantity': quantity,
                'productId': productId,
            },
            success:function (result) {
                alert(result.message);
            },
            error:function (errors) {  
                let error = errors.responseJSON.message;
                if(error.includes("Unauthenticated")) {
                    window.location.href= "login";
                }
                alert(errors.status + ": " + error);

            }
        })
    }
  
</script>