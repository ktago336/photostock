
document.addEventListener('DOMContentLoaded',function (){
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
});

