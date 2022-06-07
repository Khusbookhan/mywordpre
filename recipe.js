function fetch(){

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'get',
        data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
        success: function(data) {
            jQuery('#datafetch').html( data );
        }}
