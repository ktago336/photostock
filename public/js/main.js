
document.addEventListener('DOMContentLoaded',function (){
    //Обновление фотки профиля
    $("#profileImage").on('change', function (){
        updateProfileImage($(this).data('userId'));
    })


    $("#communityImage").on('change', function (){
        updateCommunityImage($(this).data('communityId'));
    })


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
    $('body').on('click',".like-btn",function(){
        let likeBtn = $(this);
        let likeable_id = $(this).data('likeableId');
        let likeable_type = $(this).data('likeableType');
        $.ajax({
            url: '/like',
            type: 'post',
            data: {
                likeable_id: likeable_id,
                likeable_type:likeable_type
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


    //Открытие комментариев
    $(".comment-btn").on('click',function (){
        var commentable_type = $(this).data('commentableType');
        var commentable_id = $(this).data('commentableId');
console.log(commentable_type);
        var form = $('#post-comment');
        form.data('commentableType',commentable_type);
        form.data('commentableId',commentable_id);
console.log(form.data('commentableType'));

        $.ajax({
            url: '/get/comments',
            type: 'get',
            data: {
                commentable_type: commentable_type,
                commentable_id:commentable_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $("#comments-array").html(data.cards);
            },
            error: function (data) {
                console.log(data)
            }

        });

        //TODO через $(this).closest('.post') сделать заполнение модалки инфой поста
    });


    //Отправка комментария
    $('#post-comment').on('submit',function (e){
        e.preventDefault();
        var data = new FormData($(this)[0]);
        data.append('commentable_type',$(this).data('commentableType')??null);
        data.append('commentable_id',$(this).data('commentableId')??null);

        let index=1;
        var images = $('#file-input-comment').prop('files');
        if (images != null) {
            Array.prototype.forEach.call(images, function (file) {
                data.append('image-' + (index++).toString(), file);
            });
            data.append('numberOfImages', index.toString());
        }

        $.ajax({
            url: '/send/comment',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $.ajax({
                    url: '/get/comments',
                    type: 'get',
                    data: {
                        commentable_type: data.commentable_type,
                        commentable_id:data.commentable_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        $("#comments-array").html(data.cards);
                    },
                    error: function (data) {
                        console.log(data)
                    }

                });
            },
            error: function (data) {
                console.log(data)
            }

        });
    })

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

function updateProfileImage(id){
    if ($('#profileImage')[0].files.length>0){
        let file = $('#profileImage')[0].files[0];
        let data = new FormData();

        data.append('image', file);

        $.ajax({
            url: '/update/photo/profile/'+id,
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                console.log(data)
            }

        });
    }
}


function updateCommunityImage(id){
    if ($('#communityImage')[0].files.length>0){
        let file = $('#communityImage')[0].files[0];
        let data = new FormData();

        data.append('image', file);

        $.ajax({
            url: '/update/photo/community/'+id,
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                console.log(data)
            }

        });
    }
}

