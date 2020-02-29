<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{ UrL::asset('css/rating.css') }}">
<!------ Include the above in your HEAD tag ---------->
<div class="container">
  <h3 id = "start"></h3>

  <div class="row">
    <div class="rating">
      
      <input type="radio" id="star5" name="rating" value="5" onClick="myRating(5)" /><label for="star5" title="very good">5 stars</label>
      <input type="radio" id="star4" name="rating" value="4"  onClick="myRating(4)"/><label for="star4" title="good">4 stars</label>
      <input type="radio" id="star3" name="rating" value="3"  onClick="myRating(3)"/><label for="star3" title="intermidiate">3 stars</label>
      <input type="radio" id="star2" name="rating" value="2"  onClick="myRating(2)"/><label for="star2" title="bad">2 stars</label>
      <input type="radio" id="star1" name="rating" value="1"  onClick="myRating(1)"/><label for="star1" title="very bad">1 star</label>
    </div>
  </div>
  <div class="col-12">
     <input class="form-control border-0 border-bottom" type="text" name="comments" placeholder="please enter your comments...">
  </div>
</div>
  <script>


  function myRating(value) {
  document.getElementById('start').innerHTML = value + "/5";
  }
  </script>