var vrp = new Object();
(function($){
	vrp.refresh_list = function(data_id, obj, type) {
		if (vrp.refresh_list.jqxhr)
			vrp.refresh_list.jqxhr.abort();

        vrp.data = {
            post_id : data_id,
            index : obj.parents('tr').children('td:first').html(),
            type : type,
        };

        vrp.refresh_list.jqxhr = $.getJSON({
            url: vrp_info.ajax_url+'refresh-list/?uid=' + Math.random(),
            type: 'post',
            data: vrp.data,
            async : true,
            beforeSend: function() {
                $('table.vrp-mapping-list').addClass('disabled-class');
            },
            success: function(response) {
                response.obj = obj;
                if( response.status === 'ok' ) {
                    if( response.content == 'reload' ) {
                        if( type == 'delete' )
                            obj.parents('tr').remove();
                        document.location.reload();
                    }
                    else
                        obj.parents('tr').html(response.content);
                }
                else if( response.status === 'fail' ) {
                    obj.parents('tr').remove();
                }
            },
            complete: function(xhr, status) {
                if($('table.vrp-mapping-list').hasClass('disabled-class'))
                    $('table.vrp-mapping-list').removeClass('disabled-class');
            },
        });
	}

	jQuery(function($){
		$(document).on('click', 'table.vrp-mapping-list a[data-click="refresh"]', function(e){
            var data_id = $(this).attr('data-id');
            vrp.refresh_list(data_id, $(this), 'refresh');
		});

		$(document).on('click', 'table.vrp-mapping-list a[data-click="delete"]', function(e){
            var data_id = $(this).attr('data-id');
            vrp.refresh_list(data_id, $(this), 'delete');
		});

		$(document).on('click', 'button[data-click="refresh-all"]', function(e){
            e.preventDefault();
            var data_id = $(this).attr('data-id');
            vrp.refresh_list(data_id, $(this));
		});
	});
})(jQuery);