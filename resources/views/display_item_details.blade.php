<item-component :item="{{ json_encode($item->id) }}"></item-component>

<div class="card text-center" style="width: 100%;">
  <div style="height: 350px" class="card-img-top">
    <img src="/uploads/{{$item->imageurl}}" style="max-width: 100%;max-height: 100%;">
  </div>
  <div class="card-body">
    <h5 class="card-title">{{$item->name}}</h5>
    <p class="card-text">{{ $item->description }}</p>
    @if($item->owner == null)         
      <p class="card-text">Posted by Anonymous</p>          
      @else
      <p class="card-text">Posted by: {{ $item->owner->name }}</p> 
    @endif
    
    <p class="card-text">Posted Date: {{date('h:m d/m/Y', strtotime($item->created_at))}}</p>
      
    @guest {{-- If there is no user logged in --}}
    <div class="alert alert-warning">
      Login or Register to call Dibs!
    </div>
    @else {{-- If there is user logged in --}}
      @if($item->owner != null)
        @if($item->owner->id == Auth::user()->id) {{-- If the user logged in is the one who posted the item --}}
          <div class="alert alert-warning">You can't call dibs in your own items</div>
        @else
          @if($item->dibscaller == null) {{-- If no one called dibs yet --}}
            <a href="/call_dibs/{{$item->id}}" class="btn btn-primary">Call Dibs</a>
          @else
            @if($item->dibscaller->id == Auth::user()->id)
              <div class="alert alert-success">Dibs called by you</div>
            @else
              <div class="alert alert-warning">Dibs called by: {{ $item->dibscaller->name }}</div>
            @endif
          @endif
        @endif
        @else
        <div class="alert alert-warning">Dibs can't be called on anonymous posts</div>
      @endif
    @endguest
  </div>
</div>


