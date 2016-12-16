var MobileView;

MobileView = {
    updateMenuBackground : function(color){
        $('.mobile-side').css({'background':'#' + color});
    },
    
    updateMenuColor : function(color){
       $(".s_nav li a").css({'color': '#'+color });
    },
    
    updateMenuFontSize: function(size){
        console.log(size );
        if(size == 'micro')
            size= 'x-small';
        if(size == 'extra_large')
            size = 'x-large';
        $(".s_nav li > a").css('font-size',size + ' !important');
    },
    
    updateMenuFontFamily: function(fontName){
        console.log(fontName );
        $(".s_nav li > a").css({'font-family': fontName });
    },
    
    updateMenuListItems : function( items ){
        
        $('ul.s_nav').html('');
        $(items).each(function(index,item){
            $('ul.s_nav').append('<li><a>'+ $(item).find('a').text() +'</a></li>');
            
        })
    }
}
