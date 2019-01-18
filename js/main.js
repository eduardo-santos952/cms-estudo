$(function(){
    cliqueMenu();
    scrollItem();
    function cliqueMenu(){
        $('#menu-principal a, .list-group a').click(function(){
            $('.list-group a, .li').removeClass('active').removeClass('cor-padrao');
            $('#menu-princial a').parent().removeClass('active');

            $('#menu-principal a[ref_sys='+$(this).attr('ref_sys')+']').parent().addClass('active');
            $('.list-group a[ref_sys=' + $(this).attr('ref_sys') + ']').addClass('active cor-padrao');
            return false;
        })
    }
    function scrollItem(){
        $('#menu-principal a, .list-group a').click(function(){
            var ref = '#'+$(this).attr('ref_sys')+'_section';
            var offset = $(ref).offset().top;
            $('html,body').animate({'scrollTop':offset-60});
            if($(window)[0].innerWidth <= 768){
                $('.icon-bar').click();
            }
            return false;
    })
}
    

});