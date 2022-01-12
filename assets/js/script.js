var wrl = new Object();
(function($){
	wrl.refresh_list = function(data_id, obj) {
		if (wrl.refresh_list.jqxhr)
			wrl.refresh_list.jqxhr.abort();

        wrl.data = {
            post_id : data_id,
            index : obj.parents('tr').children('td:first').html(),
        };

        wrl.refresh_list.jqxhr = $.getJSON({
            url: wrl_info.ajax_url+'refresh-list/?uid=' + Math.random(),
            type: 'post',
            data: wrl.data,
            async : true,
            beforeSend: function() {
                $('table.wp-mapping-list').addClass('disabled-class');
            },
            success: function(response) {
                response.obj = obj;
                if( response.status === 'ok' ) {
                    if( response.content == 'reload' )
                        document.location.reload();
                    else
                        obj.parents('tr').html(response.content);
                }
                else if( response.status === 'fail' ) {
                    obj.parents('tr').remove();
                }
            },
            complete: function(xhr, status) {
                if($('table.wp-mapping-list').hasClass('disabled-class'))
                    $('table.wp-mapping-list').removeClass('disabled-class');
            },
        });
	}

	jQuery(function($){
		$(document).on('click', 'table.wp-mapping-list a[data-click="refresh"]', function(e){
            var data_id = $(this).attr('data-id');
            wrl.refresh_list(data_id, $(this));
		});

		$(document).on('click', 'button[data-click="refresh-all"]', function(e){
            e.preventDefault();
            var data_id = $(this).attr('data-id');
            wrl.refresh_list(data_id, $(this));
		});
	});
})(jQuery);