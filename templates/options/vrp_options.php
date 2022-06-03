<form name="vrp_tables" class="vrp_tables" method="post" action="">
	<table><tbody><tr><td><input type="hidden" name="vrp_options" value="1">WP Related Posts Options</td></tr></tbody></table>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" class="posts_limit">
					<label for="posts_limit"><strong><?php esc_html_e( 'Posts Limit', 'wrpbt-lng' ); ?></strong> <small>(No of posts to show in Related Post Section)</small></label>
				</th>
				<td class="posts_limit">
					<label><input type="number" name="posts_limit" id="posts_limit" min="1" max="10" value="<?php echo esc_attr($posts_limit); ?>"> </label>
				</td>
				<th scope="row" class="heading">
					<label for="heading"><strong><?php esc_html_e( 'Section Heading', 'wrpbt-lng' ); ?></strong> <small>(Heading to be shown in Related Posts Section in frontend)</small></label>
				</th>
				<td class="heading">
					<label><input type="text" name="heading" id="heading" min="1" max="10" value="<?php echo esc_attr($heading); ?>"> </label>
				</td>
			</tr>
			<tr>
				<th scope="row" class="description_length">
					<label for="description_length"><strong><?php esc_html_e( 'Description Length', 'wrpbt-lng' ); ?></strong></label>
				</th>
				<td class="description_length">
					<label><input type="number" name="description_length" id="description_length" min="1" value="<?php echo esc_attr($description_length); ?>"> </label>
				</td>
				<th scope="row">
					<label for="sort_by"><strong><?php esc_html_e( 'Order By', 'wrpbt-lng' ); ?></strong></label>
				</th>
				<td>
					<select name="sort_by" id="sort_by" required="">
						<option value="random"> Random </option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="post_types"><strong><?php esc_html_e( 'Post Types', 'wrpbt-lng' ); ?></strong> <small>(Select post type where the tags will be enabled)</small></label>
				</th>
				<td>
					<div style="min-height: 100px;max-height: 300px;overflow-x: scroll;padding: 10px;border: 1px solid black;border-radius: 12px;">
						<?php
							foreach ( (array) get_post_types( [ 'public' => true ], 'objects' ) as $type ) {
									// $type = str_replace('-', ' ', $type);
									echo "<label><input type='checkbox' name='post_types[]' value='" . esc_attr($type->name) . "' " . ( in_array( $type->name, $post_types ) ? 'checked=""' : '' ) . ">" . ucwords( esc_attr($type->label) ) . "</label><br>";
							}
						?>
					</div>
				</td>
			</tr>
			<tr>
				<th colspan="4" scope="row" class="rp_template">
					<label for="rp_template"><strong><?php esc_html_e( 'Related Posts Template', 'wrpbt-lng' ); ?></strong></label><br>
					<small>
						1. &lt;vrp-repeater-main&gt; For repeative block, use this wrapper &lt;/vrp-repeater-main&gt;<br>
						2. &lt;vrp-repeater-no-result&gt; For no results block &lt;/vrp-repeater-no-result&gt;<br>
						3. Variables -
						<span>a) %%post_title%% - For post title </span>
						<span>b) %%post_description%% - For post description </span>
						<span>c) %%post_ur%% - For post permalink </span>
					</small>
				</th>
			</tr>
			<tr>
				<td class="rp_template" colspan="4">
					<label><?php wp_editor($rp_template, 'editor-'. wp_create_nonce('rp_template'), $settings = array('textarea_name' => 'rp_template')); ?></label>
				</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo submit_button();?></td>
				<td><p class="submit"><button data-click="refresh-all" data-id="0" class="button button-primary">Reset All Listings</button</p></td>
			</tr>
		</tbody>
	</table>
</form>