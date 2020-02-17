<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<form class="form-horizontal" action="{{ route('product') }}" method="post" enctype="multipart/form-data">
@csrf
<fieldset>

<!-- Form Name -->
<legend><a href="{{ route('home') }}" class="alert alert-dark">Back</a></legend>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">PRODUCT NAME</label>  
  <div class="col-md-4">
  <input id="product_name" name="product_name" placeholder="PRODUCT NAME" class="form-control input-md" required="" type="text">
  </div>
  @error('product_name')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_type">PRODUCT TYPE</label>
  <div class="col-md-4">
    <select id="product_type" name="product_type" class="form-control">
        <option value="Phone">Phone</option>
        <option value="Close"></option>
        @if(!$products->isEmpty())
        @foreach($products->product_type as $type)
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
        @endif
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="description">PRODUCT DESCRIPTION</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="description" name="description" required></textarea>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="percentage_discount">PERCENTAGE DISCOUNT (%)</label>  
  <div class="col-md-4">
  <input id="discount_percent" name="percentage_discount" placeholder="PERCENTAGE DISCOUNT" class="form-control input-md" required="" type="text" max ="100">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="stock">STOCK</label>  
  <div class="col-md-4">
  <input id="stock" name="stock" placeholder="STOCK" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="enable_display">ENABLE DISPLAY</label>  
  <div class="col-md-4">
  <select name="enable_display" id="enable_display">
      <option value="1">Enable</option>
      <option value="0">Disable</option>
  </select>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">

    
 <!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">main_image</label>
  <div class="col-md-4">
    <input id="filebutton" name="filebutton" class="input-file" type="file">
  </div>
</div>
<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">auxiliary_images</label>
  <div class="col-md-4">
    <input id="filebutton" name="filebutton" class="input-file" type="file">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">Single Button</label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">ADD</button>
  </div>
  </div>

</fieldset>
</form>
