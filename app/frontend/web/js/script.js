$(document).ready(function (){
   let follow = $('.follow');
    let followX = follow.pageX;
    let followY = follow.pageY;

   follow.mouseenter(function (){
       follow.addClass('following');
       follow.removeClass('unfollow');
           $(document).mousemove(function(e) {
               if(follow.hasClass('following')) {
                   follow.offset({
                       left: e.pageX,
                       top: e.pageY
                   });
               }
           });
   })
   $(document).click(function () {
        console.log('click');
       follow.offset({
           left: followX,
           top: followY
       });
       follow.addClass('unfollow');
       follow.removeClass('following');

   });
});