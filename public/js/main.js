
document.addEventListener('DOMContentLoaded',function (){
    //Выпадающая подробная информация в профиле
    $("#show-additional").on('click',function (){
        if(!$("#additional-info").is(":visible")){
            $("#additional-info").show(500);
            $("#show-additional").text('Скрыть подробную информацию');
            return;
        }

        if($("#additional-info").is(":visible")){
            $("#additional-info").hide(500);
            $("#show-additional").text('Показать подробную информацию');
            return;
        }
    });


    //Выпадающий инпут написания поста на странице
    $("#create-post-toggle").on('click',function (){
        if(!$("#create-post-form").is(":visible")){
            $("#create-post-form").show(500);
            return;
        }

        if($("#create-post-form").is(":visible")){
            $("#create-post-form").hide(500);
            return;
        }
    });


    //Процедура отправки лайка
    $(".like-btn").on('click',function(){
        let likeBtn = $(this);
        let post_id = $(this).data('postId');
        console.log(post_id);
        $.ajax({
            url: '/like',
            type: 'post',
            data: {
                post_id: post_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                let numberOflIkes = Number(likeBtn.find(".numberOfLikes").first().text());

                if(data.increase == true){
                    likeBtn.find(".numberOfLikes").text(numberOflIkes+1);
                    likeBtn.find('.like-symbol').addClass('red');
                }
                if(data.increase == false){
                    likeBtn.find(".numberOfLikes").text(numberOflIkes-1);
                    likeBtn.find('.like-symbol').removeClass('red');

                }

            },
            error: function (data) {
                console.log(data)
            }

        });
    });


    //Обработка отрпавки сообщения
    $("#sendMessage").on('click',function (){
        sendMessage();
    })
});
//Добавление сообщения в чат
function addMessage(me, text, name, image, time){
    if(me){
        var msghtml = `
                <div class="my-message d-flex justify-content-end">
                    <img class="author-image" src="${image}" alt="Author Image">
                    <div class="post-content">
                        <p><b>Вы: </b>${text}</p>
                        <div class="post-info d-flex justify-content-between align-items-end">
                            <span class="publish-date">${time}</span>
                        </div>
                    </div>
                </div>
            `;
    }
    else{
        var msghtml = `
                <div class="their-message d-flex justify-content-end">
                    <img class="author-image" src="${image}" alt="Author Image">
                    <div class="post-content">
                        <p><b>${name}: </b>${text}</p>
                        <div class="post-info d-flex justify-content-between align-items-end">
                            <span class="publish-date">${time}</span>
                        </div>
                    </div>
                </div>
            `;
    }

    $("#chat").append(msghtml);
}

function sendMessage(){
    var text = $("#textToSend").val();
    $("#textToSend").val('')
    if (!text || text===''){
        return;
    }
    var data = new FormData();
    data.append('to_id',to_id??0);
    data.append('text',text);

    let index=1;
    var images = $('#attach_images').prop('files');
    if (images != null) {
        Array.prototype.forEach.call(images, function (file) {
            data.append('image-' + (index++).toString(), file);
        });
        data.append('numberOfImages', index.toString());
    }

    $.ajax({
        url: '/send-message',
        type: 'post',
        data: data,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (data) {
            addMessage(true, text, 'Вы', ProfileImage, 'Только что')
        },
        error: function (data) {
            console.log(data)
        }

    });
}

