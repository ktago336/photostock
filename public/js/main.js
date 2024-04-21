
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
});

