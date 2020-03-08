<title>create new product</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<form class="form-horizontal" action="{{ route('product.update', compact('product')) }}" method="post" enctype="multipart/form-data">
@method('patch')
@csrf
<fieldset>

<!-- Form Name -->
<legend><a href="{{ route('home') }}" class="alert alert-dark">Back</a></legend>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">PRODUCT NAME</label>  
  <div class="col-md-4">
  <input id="name" name="name" placeholder="PRODUCT NAME" class="form-control input-md" required="" type="text" value="{{ $product->name }}">
  </div>
  @error('name')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="catagory">PRODUCT TYPE</label>
  <div class="col-md-4">
    <select id="catagory_id" name="catagory_id" class="form-control">
        @if(!$catagories->isEmpty())
            @foreach($catagories as $catagory)
              <option value="{{ $catagory->id }}">{{ $catagory->catagory }}</option>
            @endforeach
        @endif
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="description">PRODUCT DESCRIPTION</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="description" name="description" required>
      {{ $product->description }}
    </textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="price $" >Price ($)</label>
  <div class="col-md-4">                     
    <input id="price" name="price" placeholder="PRICE" class="form-control input-md" required="" type="number" step="0.01" value="{{ $product->price }}">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="percentage_discount">PERCENTAGE DISCOUNT (%)</label>  
  <div class="col-md-4">
  <input id="percentage_discount" name="percentage_discount" placeholder="PERCENTAGE DISCOUNT" class="form-control input-md" required="" type="number" max="100" value="{{ $product->percentage_discount }}">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="stock">STOCK</label>  
  <div class="col-md-4">
  <input id="stock" name="stock" placeholder="STOCK" class="form-control input-md" required="" type="number" value="{{ $product->stock }}">
    
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
  <label class="col-md-4 control-label" for="image_source">main_image</label>
  <div class="col-md-4">
    <input id="image_source" name="image_source" class="input-file" type="file">
  </div>
  @error('image_source')
      <small class="text-danger">{{ $message }}</small>
  @enderror
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="auxiliary_image_source">auxiliary_images</label>
  <div class="col-md-4">
    <input id="auxiliary_image_source" name="auxiliary_image_source" class="input-file" type="file">
  </div>
  @error('auxiliary_image_source')
      <small class="text-danger">{{ $message }}</small>
  @enderror
</div>


<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">Single Button</label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save Change</button>
  </div>
  </div>

</fieldset>
</form>
@if($errors->any())
  @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
  @endforeach
@endif