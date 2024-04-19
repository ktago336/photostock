@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content">

        <div class="top-bar">
            {{$profile->name??''}} {{$profile->surname??''}}

        </div>
        <div class="container-main" style="margin-top: 0px">
            <div class="profile-header">
                <img class="profile-picture" src="{{$profile->avatar()??config('app.profile_placeholder')}}" alt="Profile Picture">

            </div>
            <div class="profile-content">
                <div class="d-flex justify-content-between align-items-end border-bottom border-5">
                    <h2 style="margin: 0">
                        {{$profile->name??''}} {{$profile->surname??''}}
                    </h2>
                    <div id="show-additional" role="button">Показать подробную информацию</div>
                </div>
                <div class="w-50">
                    @for($j=0;$j<=2;$j++)
                        <div class="d-flex justify-content-between">
                            <div class="profile-info">Род деятельности</div>
                            <div class="profile-info">Прикольный</div>
                        </div>
                    @endfor
                    <div id="additional-info" style="display: none">
                        @for($j=0;$j<=2;$j++)
                            <div class="d-flex justify-content-between">
                                <div class="profile-info">Род деятельности</div>
                                <div class="profile-info">Прикольный</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-end border-bottom border-top border-5 border-dark category-header">
                    <h4 class="px-3 category-header-title">Стена</h4>
                </div>
                <div class="m-3">
                    <form action="{{route('create.post',['id'=>$profile->id])}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @if($errors->any())
                            {!! implode('', $errors->all('<div style="color:red;">:message</div>')) !!}
                        @endif
                        <p role="button" id="create-post-toggle">Написать @include('app.svg.pen',['height'=>'12px'])</p>
                        <div id="create-post-form" style="display: none">
                            <div class="form-group">
                                <textarea required name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="d-flex flex-row-reverse mt-3">
                                <button type="submit" class="btn btn-primary">Отправить</button>
                                <div class="form-group">
                                    <div class="file-input">
                                        <input
                                            type="file"
                                            name="image"
                                            id="file-input"
                                            class="file-input__input"
                                        />
                                        <label class="file-input__label" for="file-input">
                                            @include('app.svg.clip'  )
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>


                @foreach($profile->posts as $post)
                    @include('blocks.post',compact('post'))
                @endforeach



                <!-- Add more posts, friends, etc. -->
            </div>
        </div>
    <!-- More feed items go here -->
    </div>

@endsection
