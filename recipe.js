
jQuery(document).ready(function($){

    $("#keyword").on("keyup",function(){
   // console.log( frontend_ajax_object.ajaxurl)
        var fetch = $(this).val();
       
        jQuery.ajax({
            url:   frontend_ajax_object.ajaxurl,
            type: 'post',
            data:  { 
            action: 'data_fetch',  
            keyword: fetch
            },
            success:function(data) {
                console.log(data)
                 jQuery('#primary').html( data );
    
            }
        });
    
    
      
    
    });
    
     $("select").change(function(){

       $("#filter").on("change",function(){
   // console.log( frontend_ajax_object.ajaxurl)
        var fetch = $(this).val();
     jQuery.ajax({
            url:   frontend_ajax_object.ajaxurl,
            type: 'post',
            data:  { 
            action: 'filter',  
            keyword: fetch
            },
            success:function(data) {
                console.log(data)
                 jQuery('#primary').html( data );
    
            }
        });
    
    
      
    
    });
  });
    
    });