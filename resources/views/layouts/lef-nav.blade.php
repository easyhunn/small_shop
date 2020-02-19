<div class="card">
  <div class="card-header">
    <h5>Catagory</h5>

  </div>
  <ul class="list-group list-group-flush">
    @foreach($catagories as $catagory) 
      <li class="list-group-item">
        <a href="{{ route('catagory.show', compact('catagory')) }}" class="text-dark">{{ $catagory->catagory }}</a>
        @if($catagory->products()->count())
        <span class="badge badge-primary badge-pill">{{ $catagory->products()->count() }}</span>
        @endif
      </li>  
    @endforeach  
  </ul>
</div>