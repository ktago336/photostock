@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content">

        <div class="container-main responsive-flex-content" style="margin-top: 0px">
            <div class="profile-header">

                @if(\Illuminate\Support\Facades\Auth::id() == $community->user->id)
                    <label for="communityImage" style="cursor:pointer;">
                        <img class="profile-picture" src="{{$community->avatar()->url??config('app.profile_placeholder')}}" alt="Profile Picture">
                    </label>
                    <input id="communityImage" data-community-id="{{$community->id}}" type="file" accept="image/png, image/jpeg" hidden>
                @else
                    <img class="profile-picture" src="{{$community->avatar()->url??config('app.profile_placeholder')}}" alt="Profile Picture">
                    @if(\Illuminate\Support\Facades\Auth::user()->isSubscribed($community))
                        <button class="subscribe-button" style="background-color:#d3d3d3; color: #013684;" onclick=" if (confirm('Вы хотите отписаться?')) location.href='{{route('delete.community.subscription',['id'=>$community->id])}}'">Вы подписаны</button>

                    @else
                        <button class="subscribe-button" onclick="location.href='{{route('subscribe.community',['id'=>$community->id])}}'">Подписаться</button>
                    @endif
                @endif

                    <div class="d-flex justify-content-between align-items-end border-bottom border-top border-5 border-dark category-header" style="margin-top: 2ch">
                        <h4 class="px-3 category-header-title">Подписчики {{$community->subscribers()->count()}}</h4>
                    </div>
                    @include('blocks.friends', ['friends'=>$lastSubscribers])

            </div>
            <div class="profile-content">
                <div class="d-flex justify-content-between align-items-end border-bottom border-5">
                    <h2 style="margin: 0">
                        {{$community->name??''}}
                    </h2>
                    <div id="show-additional" role="button">Показать подробную информацию</div>
                </div>
                <div class="w-50">
                    <div class="profile-info">{{$community->bio??''}}</div>

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
                    <h4 class="px-3 category-header-title">Фото</h4>
                </div>

                @include('blocks.gallery',['images'=>$community->images()->get()])
                <div class="d-flex justify-content-between align-items-end border-bottom border-top border-5 border-dark category-header">
                    <h4 class="px-3 category-header-title">Стена</h4>
                </div>
                {{-- //TODO implement permission to write on others' wall --}}
                @if(\Illuminate\Support\Facades\Auth::id() == $community->user->id)
                    <div class="m-3">
                        <form action="{{route('create.community.post',['id'=>$community->id])}}" enctype="multipart/form-data" method="POST">
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
                @endif


                @foreach($community->wall()->latest()->get() as $post)
                    @include('blocks.post',compact('post'))
                @endforeach



                <!-- Add more posts, friends, etc. -->
            </div>
        </div>
    <!-- More feed items go here -->
    </div>

@endsection
