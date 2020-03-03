<nav class="navbar navbar-expand-lg navbar-light col-10">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('product.create') }}">New</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('cart.index') }}">Cart</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      
    </ul>
    <form class="form-inline my-2 my-lg-0 col-6" action="/product/search" method="get">
      <input class="form-control col-12" list="allProduct" name="data" type="search" placeholder="Search" aria-label="Search" oninput="getProduct()" id="topSearch">
      <datalist id="allProduct"></datalist>
    </form>
  </div>

</nav>

<script>
    let recommends = [];
    let recommendIndex = 0;

    function getProduct() {
        let keyWord = document.getElementById("topSearch").value;

        $.ajax({
          url:"/product/getAll",
          type:"get",
          success: function(result) {

              for (i in result) {
                let recommend = result[i].product_name;
                if(recommend.includes(keyWord)) {
                  addRecommendProduct(recommend);
                }
              }
          },
          error: function (result) {
            alert(result.status + ": " +result.responseJSON.message);
          }
        })
    }
    function existRecommend(recommend) {
        for(i in recommends) {
          if(recommends[i] == recommend) {
            return true;
          }
        }
        return false;
    }
    function addRecommendProduct(recommend) {
        if(existRecommend(recommend))
          return;
        let list = document.getElementById("allProduct");
        let option = document.createElement("option");
        option.setAttribute("value", recommend);
        list.appendChild(option);
        recommends[recommendIndex] = recommend;
        recommendIndex++;
    }
   
</script>

