@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content">

                <div id="chat">
                    @foreach($messages as $message)
                        @include('blocks.message',compact('message'))
                    @endforeach
                </div>


                    <div class="form-group w-100 d-flex" style="margin-bottom: 50px; bottom: 50px; position:sticky; background-color:#e1dada">
                        <textarea required name="text" class="form-control" id="textToSend" rows="3" placeholder="Напишите сообщение" style="height:7ch;"></textarea>
                        <div class="d-flex flex-row-reverse mt-3">
                            <div class="form-group">
                                <div class="file-input">
                                    <input id="attach_images"
                                        type="file"
                                        name="image"
                                        class="file-input__input"
                                        multiple
                                    />
                                    <label class="file-input__label" for="attach_images">
                                        @include('app.svg.clip'  )
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button id="sendMessage" type="button" class="firm-btn form-control btn" style="width:15%">Отправить</button>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded',function (){
            window.Echo.private(`messages.{{\Illuminate\Support\Facades\Auth::id()}}`) //
                .listen('MessageSent', (e) => {
                    console.log(e);
                    addMessage(false, e.message.text, TheirName, TheirImage, 'Только что');
                });
        })
    </script>

@endsection
