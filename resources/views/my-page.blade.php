@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content">

        <div class="top-bar">
            Павел Дуров
        </div>
        <div class="container-main" style="margin-top: 0px">
            <div class="profile-header">
                <img class="profile-picture" src="{{$profile->avatar()??config('app.profile_placeholder')}}" alt="Profile Picture">

            </div>
            <div class="profile-content">
                <div class="d-flex justify-content-between align-items-end border-bottom border-5">
                    <h2 style="margin: 0">
                        Павел дуров
                    </h2>
                    <div role="button">Показать подробную информацию</div>
                </div>
                <div class="w-50">
                    @for($j=0;$j<=2;$j++)
                        <div id="additional-info" class="d-flex justify-content-between">
                            <div class="profile-info">Род деятельности</div>
                            <div class="profile-info">Прикольный</div>
                        </div>
                    @endfor
                </div>

                <div class="d-flex justify-content-between align-items-end border-bottom border-top border-5 border-dark category-header">
                    <h4 class="px-3 category-header-title">Стена</h4>
                </div>


                @for($j=1; $j<5; $j++)
                    @include('blocks.post')
                @endfor



                <!-- Add more posts, friends, etc. -->
            </div>
        </div>
    <!-- More feed items go here -->
    </div>

@endsection
