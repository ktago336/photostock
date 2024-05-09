<div class="container mt-4">
  <ul class="list-unstyled row">
    <!-- First row of 3 items -->
    @foreach($friends as $friend)
      <li class="col-md-4 square">
        <a style="text-decoration: none; color: inherit" href="{{route('user.page',$friend)}}" target="_blank">
          <img class="thumbnail-image" src="{{$friend->avatar()->image}}"> <p>{{$friend->name}}</p>
        </a>
      </li>
    @endforeach
  </ul>
</div>
