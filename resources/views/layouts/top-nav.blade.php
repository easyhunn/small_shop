
<nav class="navbar navbar-expand-lg navbar-light col-10">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
      </li>
      @can('create', App\product::class)
        <li class="nav-item">
          <a class="nav-link" href="{{ route('product.create') }}">New</a>
        </li>
      @endcan
      <li class="nav-item">
        <a class="nav-link" href="{{ route('cart.index') }}">Cart</a>
      </li>
      <li class="nav-item">
            <a class="nav-link" href="/process/{{ Auth::user()->id }}">Process</a>
          </li>
      @can('viewAny', App\Cart::class)
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.all') }}">Order manage</a>
        </li>
      @endcan
      
    
      
    </ul>
    <form class="form-inline my-2 my-lg-0 col-6" action="/product/search" method="get">
      <input class="form-control col-12" list="allProduct" name="data" type="search" placeholder="Search" aria-label="Search" id="topSearch" value="{{ old('data') }}">
      <datalist id="allProduct"></datalist>
    </form>
  </div>

</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let recommends = [];
    let recommendIndex = 0;

    function getProduct() {
        try{
        $.ajax({
          url:"/product/getAll",
          type:"get",
          success: function(result) {

              for (i in result) {

                addRecommendProduct(result[i].name);    
              }
          },
          error: function (result) {
            alert(result.status + ": " +result.responseJSON.message);
          }
        })
        } catch (e) {
          alert(e);
        }
    }

    function addRecommendProduct(recommend) {

        let list = document.getElementById("allProduct");
        let option = document.createElement("option");
        option.setAttribute("value", recommend);
        list.appendChild(option);
        recommends[recommendIndex] = recommend;
        recommendIndex++;
    }

    getProduct();
</script>

