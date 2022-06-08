
		jQuery.ajax({
        url: 'recipe_obj.ajax_url',
        type: 'post',
        data: { 'action': 'data_fetch',
                'keyword': jQuery('#keyword').val() },
        success: function(data) {
            jQuery('#primary').html( data );
        }

    
    });
