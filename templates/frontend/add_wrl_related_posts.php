<?php
	# get repeater block from the template
	preg_match_all('/<wrl-repeater-main>(.*)<\/wrl-repeater-main>/si', stripslashes($rp_template), $repeater_main);
	# get no results block from the template
	preg_match_all('/<wrl-repeater-no-result>(.*)<\/wrl-repeater-no-result>/si', stripslashes($rp_template), $repeater_no_result);
	$repeater = '';
	if( count( $related_content_data ) > 0 ) :
		foreach( $related_content_data as $cont ) :
			$repeater .= $repeater_main[1][0];
			$repeater = str_replace("%%post_title%%", $cont['title'], $repeater);
			$repeater = str_replace("%%post_description%%", $cont['description'], $repeater);
			$repeater = str_replace("%%post_url%%", $cont['post_url'], $repeater);
		endforeach;
		$rp_template = str_replace($repeater_main[0][0], $repeater, $rp_template);
		$rp_template = str_replace($repeater_no_result[0][0], '', $rp_template);
	else :
		$rp_template = str_replace($repeater_main[0][0], '', $rp_template);
		$rp_template = str_replace($repeater_no_result[0][0], $repeater_no_result[1][0], $rp_template);
	endif;
	echo $rp_template;