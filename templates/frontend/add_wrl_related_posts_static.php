<div class="articles-box sidebar-box random">
	<div class="head"><h4><?= $heading ?></h4></div>
	<div class="box-content">
		<?php
			if( count( $related_content_data ) > 0 ) :
				foreach( $related_content_data as $cont ) :
		?>
					<div class="content-list">
						<h5><?= $cont['title'] ?></h5>   
						<p><?= $cont['description'] ?> <a href="<?= $cont['cta_url'] ?>"><?= $cont['cta_label'] ?></a></p>
					</div>
		<?php
				endforeach;
			else :
				echo '<div class="related-posts-error">No Related posts found!</div>';
			endif;
		?>
	</div>
</div>

<div class="articles-box sidebar-box random">
	<div class="head"><h4>Related Posts</h4></div>
	<div class="box-content">
		<wrl-repeater-main>
			<div class="content-list">
				<h5>%%post_title%%</h5>   
				<p>%%post_description%%<a href="%%post_ur%%">Read More</a></p>
			</div>
		</wrl-repeater-main>
		<wrl-repeater-no-result>
			<div class="related-posts-error">No Related posts found!</div>
		</wrl-repeater-no-result>
	</div>
</div>