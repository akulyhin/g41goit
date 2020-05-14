//  Change theme
$(document).ready(function(){
$('.theme-button').click(function() {
    $('.light-theme').toggleClass('dark-theme');
    });
});
//  Change theme END

//  Go 2 top 
$(window).scroll(function() {
    var height = $(window).scrollTop();
    
         /*Если сделали скролл на 100px задаём новый класс для header*/
    if(height > 200){
    $('.back-2-top').addClass('chown');
    } else{
         /*Если меньше 100px удаляем класс для header*/
    $('.back-2-top').removeClass('chown');
    }
    });
    //  Go 2 top END