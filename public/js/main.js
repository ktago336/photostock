
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
});

