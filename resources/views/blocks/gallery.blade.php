<!-- Page Content -->
<div class="container">
  <div class="row text-center text-lg-start">
    @foreach($images??[] as $image)
    <div class="col-lg-3 col-md-4 col-6">
      <a href="{{$image->image}}" target="_blank" class="d-block mb-4 h-100">
        <img class="img-fluid img-thumbnail" src="{{$image->image??''}}" alt="">
      </a>
    </div>
    @endforeach
  </div>
</div>
