@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content">

                <div id="chat">
                    @foreach($messages as $message)
                        @include('blocks.message',compact('message'))
                    @endforeach
                </div>


                    <div class="form-group w-50 d-flex" style="margin-bottom: 50px">
                        <textarea required name="text" class="form-control" id="textToSend" rows="3"></textarea>
                        <button id="sendMessage" type="button" class="firm-btn form-control btn">Отправить</button>
                    </div>

                <!-- Add more posts, friends, etc. -->
            </div>
        </div>
    <!-- More feed items go here -->
    </div>
    <script>
        const to_id = {{$to_id}};
        const ProfileImage = '{{\Illuminate\Support\Facades\Auth::user()->avatar()}}';
        const TheirProfileImage = '{{\Illuminate\Support\Facades\Auth::user()->avatar()}}';
        const TheirName = '{{$chatWith->name}}';
        const TheirImage = '{{$chatWith->avatar()}}';


        document.addEventListener('DOMContentLoaded',function (){
            window.Echo.private(`messages.{{\Illuminate\Support\Facades\Auth::id()}}`) //
                .listen('MessageSent', (e) => {
                    console.log(e);
                    addMessage(false, e.message.text, TheirName, TheirImage, 'Только что');
                });
        })
    </script>

@endsection