
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
    
    $("#selection").change(function(){
        var keyword = $(this).find("option:selected").text();
        var keyword = $(this).val();
        jQuery.ajax({
            url:   frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: { 
                action: 'filter',  
                keyword: keyword 
            },
            success: function(data) {
                jQuery('#primary').html( data );
            }
        });
    });
    
      
    
    
  });
    
    