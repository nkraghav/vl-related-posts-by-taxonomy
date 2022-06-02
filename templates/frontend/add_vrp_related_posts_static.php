<div class="articles-box sidebar-box random">
	<div class="head"><h4><?php echo esc_html($heading); ?></h4></div>
	<div class="box-content">
		<?php
			if( count( $related_content_data ) > 0 ) :
				foreach( $related_content_data as $cont ) :
		?>
					<div class="content-list">
						<h5><?php echo esc_html($cont['title']); ?></h5>   
						<p><?php echo wp_kses_post($cont['description']); ?> <a href="<?php echo esc_url($cont['cta_url']); ?>"><?php echo esc_html($cont['cta_label']); ?></a></p>
					</div>
		<?php
				endforeach;
			else :
				echo esc_html('<div class="related-posts-error">No Related posts found!</div>');
			endif;
		?>
	</div>
</div>

<div class="articles-box sidebar-box random">
	<div class="head"><h4>Related Posts</h4></div>
	<div class="box-content">
		<vrp-repeater-main>
			<div class="content-list">
				<h5>%%post_title%%</h5>   
				<p>%%post_description%%<a href="%%post_ur%%">Read More</a></p>
			</div>
		</vrp-repeater-main>
		<vrp-repeater-no-result>
			<div class="related-posts-error">No Related posts found!</div>
		</vrp-repeater-no-result>
	</div>
</div>