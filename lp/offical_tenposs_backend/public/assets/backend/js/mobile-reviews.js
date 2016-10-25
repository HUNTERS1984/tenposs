var MobileView;

MobileView = {
    updateMenuBackground : function(color){
        document.getElementById('mobile-side')
            .style.backgroundColor = '#' + color
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
        $(".s_nav li > a").css('cssText','font-size: '+ size + ' !important');
    },
    
    updateMenuFontFamily: function(fontName){
        console.log(fontName );
        $(".s_nav li > a").css({'font-family': fontName });
    },
    
    updateMenuListItems : function( items ){
        
        $('ul.s_nav').html('');
        $(items).each(function(index,item){
            $('ul.s_nav').append('<li><a>'+ $(item).text() +'</a></li>');
            
        })
    }
}
