$(document).ready(function(){
    $('.smoothscroll').on('click',function (e) {
        e.preventDefault();

        var target = this.hash;
        $target = $(target);
        
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - $('nav').height()
        }, 800, 'swing');
    });
});
